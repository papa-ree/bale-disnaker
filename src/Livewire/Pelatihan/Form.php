<?php

namespace Paparee\BaleDisnaker\Livewire\Pelatihan;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Paparee\BaleDisnaker\Exceptions\WilayahUnavailable;
use Paparee\BaleDisnaker\Models\CitizenProfile;
use Paparee\BaleDisnaker\Models\Draft;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;
use Paparee\BaleDisnaker\Services\WilayahClient;
use Paparee\BaleDisnaker\Support\DataCrypto;

#[Layout('tala::layouts.panel')]
#[Title('Formulir Pelatihan')]
class Form extends Component
{
    public string $type = 'masyarakat';

    public int $step = 1;

    public string $periodId = '';

    public array $data = [];

    /** Domisili mengikuti alamat KTP; disimpan di draf, tidak ikut submission. */
    public bool $sameAsKtp = false;

    public array $districts = [];

    public array $villages = ['ktp' => [], 'domisili' => []];

    public ?string $wilayahError = null;

    public bool $sessionExpired = false;

    public function mount(string $type = 'masyarakat'): void
    {
        abort_unless(config('tala.enabled'), 404);

        $this->type = $type === 'perusahaan' ? 'perusahaan' : 'masyarakat';
        $this->data = $this->blank();

        $user = auth('tala')->user();
        $period = Period::active();

        if (! $period) {
            $this->redirect(route('disnaker.pelatihan.index'), navigate: true);

            return;
        }

        // Satu permintaan per akun per periode, lintas kedua formulir.
        if (Submission::where('period_id', $period->id)->where('user_uuid', $user->uuid)->exists()) {
            $this->redirect(route('tala.panel.disnaker.status'), navigate: true);

            return;
        }

        $this->periodId = $period->id;
        $this->loadDraft($period);
        $this->loadDistricts();

        foreach (['ktp', 'domisili'] as $prefix) {
            if ($this->data[$prefix.'_district_code'] !== '') {
                $this->villages[$prefix] = $this->fetchVillages($this->data[$prefix.'_district_code']);
            }
        }
    }

    public function updated(string $name, mixed $value): void
    {
        if ($name === 'data.ktp_district_code' || $name === 'data.domisili_district_code') {
            $prefix = str_starts_with($name, 'data.ktp') ? 'ktp' : 'domisili';

            $this->data[$prefix.'_district_name'] = $this->districtName((string) $value);
            $this->data[$prefix.'_village_code'] = '';
            $this->data[$prefix.'_village_name'] = '';
            $this->villages[$prefix] = $this->fetchVillages((string) $value);

            if ($this->sameAsKtp && $prefix === 'ktp') {
                $this->syncDomisiliFromKtp();
            }

            return;
        }

        if ($name === 'data.ktp_village_code' || $name === 'data.domisili_village_code') {
            $prefix = str_starts_with($name, 'data.ktp') ? 'ktp' : 'domisili';
            $this->data[$prefix.'_village_name'] = $this->villageName($prefix, (string) $value);
        }

        if ($this->sameAsKtp && str_starts_with($name, 'data.ktp_')) {
            $this->syncDomisiliFromKtp();
        }
    }

    public function updatedSameAsKtp(mixed $value): void
    {
        if ($value) {
            $this->syncDomisiliFromKtp();
        } else {
            $this->clearDomisili();
        }

        if ($this->periodId !== '') {
            $this->saveDraft();
        }
    }

    public function next(): void
    {
        $this->validateCurrentStep();

        if ($this->step < 3) {
            $this->step++;
            $this->saveDraft();
        }
    }

    public function back(): void
    {
        $this->step = max(1, $this->step - 1);
        $this->saveDraft();
    }

    public function retryWilayah(): void
    {
        if ($this->sessionExpired) {
            $this->redirect(route('tala.redirect'), navigate: false);

            return;
        }

        $this->wilayahError = null;
        $this->loadDistricts();

        foreach (['ktp', 'domisili'] as $prefix) {
            $code = $this->data[$prefix.'_district_code'];
            $this->villages[$prefix] = $code === '' ? [] : $this->fetchVillages($code);
        }
    }

    public function restart(): void
    {
        $this->deleteDraft();
        $this->data = $this->blank();
        $this->villages = ['ktp' => [], 'domisili' => []];
        $this->sameAsKtp = false;
        $this->step = 1;
    }

    public function submit(): void
    {
        $this->validateCurrentStep();

        $user = auth('tala')->user();
        $period = Period::active();

        // Draft periode lama tetap tersimpan, tapi tidak boleh dikirim.
        if (! $period || $period->id !== $this->periodId) {
            $this->addError('submit', __('Periode pelatihan sudah tidak aktif. Silakan mulai dari awal.'));

            return;
        }

        $alreadySubmitted = Submission::where('period_id', $period->id)
            ->where('user_uuid', $user->uuid)
            ->exists();

        if ($alreadySubmitted) {
            $this->redirect(route('tala.panel.disnaker.status'), navigate: true);

            return;
        }

        $data = $this->submissionData();

        DB::transaction(function () use ($user, $period, $data) {
            CitizenProfile::updateOrCreate(
                ['user_uuid' => $user->uuid],
                [
                    'nik' => $this->data['nik'],
                    'whatsapp' => $this->data['whatsapp'],
                    'completed_at' => now(),
                ]
            );

            Submission::create([
                'period_id' => $period->id,
                'user_uuid' => $user->uuid,
                'type' => $this->type,
                'data' => $data,
                'status' => Submission::STATUS_PENDING,
                'submitted_at' => now(),
            ]);

            $this->deleteDraft();
        });

        $this->redirect(route('tala.panel.disnaker.status'), navigate: true);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.pelatihan.form');
    }

    protected function blank(): array
    {
        $base = [
            'nik' => '',
            'whatsapp' => '',
            'ktp_district_code' => '',
            'ktp_district_name' => '',
            'ktp_village_code' => '',
            'ktp_village_name' => '',
            'ktp_address' => '',
            'domisili_district_code' => '',
            'domisili_district_name' => '',
            'domisili_village_code' => '',
            'domisili_village_name' => '',
            'domisili_address' => '',
            'kebutuhan' => '',
            'keterangan' => '',
        ];

        return $this->type === 'perusahaan'
            ? $base + [
                'nama_perusahaan' => '',
                'bidang_usaha' => '',
                'alamat_usaha' => '',
                'jumlah_tenaga_kerja' => '',
            ]
            : $base + ['pekerjaan' => ''];
    }

    protected function rules(): array
    {
        return match ($this->step) {
            1 => [
                'data.nik' => ['required', 'digits:16'],
                'data.whatsapp' => ['required', 'regex:/^(?:\+?62|0)8[1-9][0-9]{6,11}$/'],
            ],
            2 => array_merge([
                'data.ktp_district_code' => ['required'],
                'data.ktp_village_code' => ['required'],
                'data.ktp_address' => ['required', 'string', 'max:255'],
            ], $this->sameAsKtp ? [] : [
                'data.domisili_district_code' => ['required'],
                'data.domisili_village_code' => ['required'],
                'data.domisili_address' => ['required', 'string', 'max:255'],
            ]),
            default => $this->type === 'perusahaan' ? [
                'data.nama_perusahaan' => ['required', 'string', 'max:255'],
                'data.bidang_usaha' => ['required', 'string', 'max:255'],
                'data.alamat_usaha' => ['required', 'string', 'max:255'],
                'data.jumlah_tenaga_kerja' => ['nullable', 'integer', 'min:1'],
                'data.kebutuhan' => ['required', 'string', 'max:2000'],
                'data.keterangan' => ['nullable', 'string', 'max:2000'],
            ] : [
                'data.pekerjaan' => ['nullable', 'string', 'max:255'],
                'data.kebutuhan' => ['required', 'string', 'max:2000'],
                'data.keterangan' => ['nullable', 'string', 'max:2000'],
            ],
        };
    }

    protected function validateCurrentStep(): void
    {
        $this->validate($this->rules(), $this->messages(), $this->validationAttributes());
    }

    /**
     * Pesan validasi Bahasa Indonesia; aturan yang sama untuk semua field
     * memakai wildcard `data.*`.
     */
    protected function messages(): array
    {
        return [
            'data.*.required' => __(':attribute wajib diisi.'),
            'data.*.string' => __(':attribute harus berupa teks.'),
            'data.*.max' => __(':attribute maksimal :max karakter.'),
            'data.*.integer' => __(':attribute harus berupa angka.'),
            'data.*.min' => __(':attribute minimal :min.'),
            'data.nik.digits' => __('NIK harus 16 digit angka.'),
            'data.whatsapp.regex' => __('Nomor WhatsApp tidak valid. Gunakan format 08xxxxxxxxxx atau +62xxxxxxxxxx.'),
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'data.nik' => __('NIK'),
            'data.whatsapp' => __('nomor WhatsApp'),
            'data.ktp_district_code' => __('kecamatan KTP'),
            'data.ktp_village_code' => __('desa/kelurahan KTP'),
            'data.ktp_address' => __('alamat KTP'),
            'data.domisili_district_code' => __('kecamatan domisili'),
            'data.domisili_village_code' => __('desa/kelurahan domisili'),
            'data.domisili_address' => __('alamat domisili'),
            'data.nama_perusahaan' => __('nama perusahaan'),
            'data.bidang_usaha' => __('bidang usaha'),
            'data.alamat_usaha' => __('alamat perusahaan'),
            'data.jumlah_tenaga_kerja' => __('jumlah tenaga kerja'),
            'data.kebutuhan' => $this->type === 'perusahaan'
                ? __('kompetensi teknis')
                : __('kebutuhan pelatihan'),
            'data.keterangan' => __('keterangan'),
            'data.pekerjaan' => __('pekerjaan saat ini'),
        ];
    }

    /**
     * NIK dan WhatsApp tidak diduplikasi ke submission; keduanya tinggal di
     * profil warga. Draft menyimpannya terenkripsi.
     */
    protected function submissionData(): array
    {
        return array_diff_key($this->data, array_flip(['nik', 'whatsapp']));
    }

    protected function loadDraft(Period $period): void
    {
        $draft = Draft::where('user_uuid', auth('tala')->user()->uuid)
            ->where('period_id', $period->id)
            ->where('type', $this->type)
            ->first();

        if (! $draft) {
            return;
        }

        $payload = $draft->payload ?? [];

        $this->step = max(1, min(3, (int) $draft->step));
        $this->data = array_merge($this->blank(), array_intersect_key($payload, $this->blank()));
        $this->data['nik'] = DataCrypto::decrypt($payload['nik_enc'] ?? null) ?? '';
        $this->data['whatsapp'] = DataCrypto::decrypt($payload['wa_enc'] ?? null) ?? '';
        $this->sameAsKtp = (bool) ($payload['same_as_ktp'] ?? false);
    }

    protected function saveDraft(): void
    {
        $payload = $this->submissionData();
        $payload['nik_enc'] = DataCrypto::encrypt($this->data['nik'] ?: null);
        $payload['wa_enc'] = DataCrypto::encrypt($this->data['whatsapp'] ?: null);
        $payload['same_as_ktp'] = $this->sameAsKtp;

        Draft::updateOrCreate(
            [
                'user_uuid' => auth('tala')->user()->uuid,
                'period_id' => $this->periodId,
                'type' => $this->type,
            ],
            ['step' => $this->step, 'payload' => $payload]
        );
    }

    protected function deleteDraft(): void
    {
        Draft::where('user_uuid', auth('tala')->user()->uuid)
            ->where('period_id', $this->periodId)
            ->where('type', $this->type)
            ->delete();
    }

    protected function syncDomisiliFromKtp(): void
    {
        foreach (['district_code', 'district_name', 'village_code', 'village_name', 'address'] as $field) {
            $this->data['domisili_'.$field] = $this->data['ktp_'.$field];
        }

        $this->villages['domisili'] = $this->villages['ktp'];

        if ($this->villages['domisili'] === [] && $this->data['ktp_district_code'] !== '') {
            $this->villages['domisili'] = $this->fetchVillages($this->data['ktp_district_code']);
        }
    }

    protected function clearDomisili(): void
    {
        foreach (['district_code', 'district_name', 'village_code', 'village_name', 'address'] as $field) {
            $this->data['domisili_'.$field] = '';
        }

        $this->villages['domisili'] = [];
    }

    protected function loadDistricts(): void
    {
        try {
            $this->districts = app(WilayahClient::class)->districts();
        } catch (WilayahUnavailable $e) {
            $this->wilayahError = $e->getMessage();
            $this->sessionExpired = $e->sessionExpired;
        }
    }

    protected function fetchVillages(string $districtCode): array
    {
        if ($districtCode === '') {
            return [];
        }

        try {
            return app(WilayahClient::class)->villages($districtCode);
        } catch (WilayahUnavailable $e) {
            $this->wilayahError = $e->getMessage();
            $this->sessionExpired = $e->sessionExpired;

            return [];
        }
    }

    protected function districtName(string $code): string
    {
        foreach ($this->districts as $district) {
            if ($district['code'] === $code) {
                return $district['name'];
            }
        }

        return '';
    }

    protected function villageName(string $prefix, string $code): string
    {
        foreach ($this->villages[$prefix] as $village) {
            if ($village['code'] === $code) {
                return $village['name'];
            }
        }

        return '';
    }
}
