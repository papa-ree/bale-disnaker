<?php

namespace Paparee\BaleDisnaker\Database\Seeders;

use Bale\Tala\Models\TalaUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Paparee\BaleDisnaker\Models\CitizenProfile;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;

/**
 * Data simulasi untuk menguji analisis AI: 100 warga + 1 permintaan per warga
 * pada periode yang sedang aktif.
 *
 * Jalankan: php artisan db:seed --class="Paparee\BaleDisnaker\Database\Seeders\AspirasiSimulasiSeeder"
 */
class AspirasiSimulasiSeeder extends Seeder
{
    private const JUMLAH = 100;

    private const VILLAGES = [
        ['3502212005', 'Banjarejo'],
        ['3502212001', 'Bareng'],
        ['3502212003', 'Krisik'],
        ['3502212006', 'Pudak Kulon'],
        ['3502212004', 'Pudak Wetan'],
        ['3502212002', 'Tambang'],
    ];

    private const DEPAN = ['Ahmad', 'Siti', 'Budi', 'Dewi', 'Eko', 'Fitri', 'Gilang', 'Hesti', 'Indra', 'Joko', 'Kartika', 'Lestari', 'Muhammad', 'Nur', 'Oki', 'Putri', 'Rahmat', 'Sri', 'Taufik', 'Wulan'];

    private const BELAKANG = ['Santoso', 'Wijaya', 'Nugroho', 'Prasetyo', 'Handoko', 'Kusuma', 'Setiawan', 'Maulana', 'Saputra', 'Hidayat', 'Anggraini', 'Wahyuni'];

    private const KEBUTUHAN = [
        'Ingin belajar menjahit untuk membuka usaha konveksi rumahan.',
        'Butuh pelatihan servis motor agar bisa membuka bengkel kecil.',
        'Ingin kursus bahasa Inggris untuk melamar kerja di bidang pariwisata.',
        'Butuh pelatihan komputer dasar dan Microsoft Office untuk kerja administrasi.',
        'Ingin belajar tata boga, terutama membuat kue kering untuk dijual.',
        'Butuh pelatihan perawatan AC dan kulkas agar bisa membuka jasa servis.',
        'Ingin belajar desain grafis untuk bekerja lepas secara online.',
        'Butuh pelatihan las listrik karena ingin menjadi tukang las profesional.',
        'Ingin kursus akuntansi dasar untuk mengurus keuangan usaha warung.',
        'Butuh pelatihan digital marketing agar produk usaha bisa dijual online.',
        'Ingin belajar budidaya ikan lele dan manajemen kolam.',
        'Butuh pelatihan barista untuk bekerja di kafe.',
        'Ingin belajar fotografi produk untuk kebutuhan usaha.',
        'Butuh pelatihan menjahit seragam sekolah untuk ibu rumah tangga.',
        'Ingin pelatihan instalasi listrik rumah dengan sertifikat.',
        'Butuh pelatihan pengelasan dan keselamatan kerja untuk bekerja di industri.',
        'Ingin belajar membuat batik tulis khas Ponorogo.',
        'Butuh pelatihan hidroponik sayuran untuk lahan sempit.',
        'Ingin kursus mengemudi dan perawatan kendaraan niaga.',
        'Butuh pelatihan public speaking dan pelayanan pelanggan.',
    ];

    private const KOMPETENSI = [
        'Operator mesin bubut CNC level dasar, 2 orang.',
        'Teknisi pengelasan SMAW bersertifikat untuk lini produksi.',
        'Teknisi instalasi listrik 3 fase dan panel distribusi.',
        'Operator quality control dengan pemahaman alat ukur presisi.',
        'Staf administrasi yang menguasai Microsoft Excel tingkat menengah.',
        'Teknisi perawatan mesin industri (mechanical maintenance).',
        'Operator forklift dengan SIO aktif.',
        'Staf digital marketing untuk pengelolaan katalog dan marketplace.',
    ];

    private const BIDANG = ['Konveksi', 'Otomotif', 'Kuliner', 'Retail', 'Konstruksi', 'Teknologi Informasi'];

    public function run(): void
    {
        $period = Period::active();

        if (! $period) {
            $this->command?->warn('Tidak ada periode aktif. Aktifkan satu periode dulu.');

            return;
        }

        DB::transaction(function () use ($period) {
            for ($i = 1; $i <= self::JUMLAH; $i++) {
                $this->seedCitizen($period, $i);
            }
        });

        $this->command?->info(self::JUMLAH.' warga + permintaan simulasi siap pada periode "'.$period->name.'".');
    }

    private function seedCitizen(Period $period, int $nomor): void
    {
        $nama = self::DEPAN[$nomor % count(self::DEPAN)].' '.self::BELAKANG[$nomor % count(self::BELAKANG)];

        $user = TalaUser::firstOrCreate(
            ['email' => 'simulasi'.$nomor.'@warga.test'],
            [
                'name' => $nama,
                'username' => 'simulasi-'.$nomor,
                'role' => 'citizen',
                'password' => bcrypt(Str::random(16)),
            ]
        );

        // NIK & WhatsApp disimpan lewat cast terenkripsi, sama seperti submit asli.
        CitizenProfile::updateOrCreate(
            ['user_uuid' => $user->uuid],
            [
                'nik' => '3502'.str_pad((string) (100000000000 + $nomor), 12, '0', STR_PAD_LEFT),
                'whatsapp' => '0857'.str_pad((string) (10000000 + $nomor), 8, '0', STR_PAD_LEFT),
                'completed_at' => now(),
            ]
        );

        $perusahaan = $nomor % 5 === 0;
        [$villageCode, $villageName] = self::VILLAGES[$nomor % count(self::VILLAGES)];

        $alamat = [
            'ktp_district_code' => '350221',
            'ktp_district_name' => 'Pudak',
            'ktp_village_code' => $villageCode,
            'ktp_village_name' => $villageName,
            'ktp_address' => 'Dusun '.($nomor % 7 + 1).' RT '.($nomor % 5 + 1).'/RW 0'.($nomor % 4 + 1),
            'domisili_district_code' => '350221',
            'domisili_district_name' => 'Pudak',
            'domisili_village_code' => $villageCode,
            'domisili_village_name' => $villageName,
            'domisili_address' => 'Dusun '.($nomor % 7 + 1).' RT '.($nomor % 5 + 1).'/RW 0'.($nomor % 4 + 1),
        ];

        $kebutuhan = [
            'kebutuhan' => $perusahaan
                ? self::KOMPETENSI[$nomor % count(self::KOMPETENSI)]
                : self::KEBUTUHAN[$nomor % count(self::KEBUTUHAN)],
            'keterangan' => $nomor % 3 === 0 ? 'Bersedia mengikuti pelatihan pada hari kerja.' : '',
        ];

        $data = $perusahaan
            ? array_merge($alamat, $kebutuhan, [
                'nama_perusahaan' => 'CV '.self::BELAKANG[$nomor % count(self::BELAKANG)],
                'bidang_usaha' => self::BIDANG[$nomor % count(self::BIDANG)],
                'alamat_usaha' => 'Jl. Raya Pudak No. '.$nomor,
                'jumlah_tenaga_kerja' => (string) ($nomor % 4 + 1),
            ])
            : array_merge($alamat, $kebutuhan, [
                'pekerjaan' => ['Belum bekerja', 'Buruh tani', 'Karyawan swasta', 'Wirausaha', 'Ibu rumah tangga'][$nomor % 5],
            ]);

        Submission::firstOrCreate(
            ['user_uuid' => $user->uuid, 'period_id' => $period->id],
            [
                'type' => $perusahaan ? 'perusahaan' : 'masyarakat',
                'data' => $data,
                'status' => Submission::STATUS_PENDING,
                'submitted_at' => now()->subDays($nomor % 10)->subMinutes($nomor * 7),
            ]
        );
    }
}
