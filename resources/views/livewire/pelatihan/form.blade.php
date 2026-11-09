@php
    $input = 'mt-1 block w-full rounded-xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 shadow-[0_1px_2px_rgba(28,25,23,0.04)] transition placeholder:text-stone-400 focus:border-accent-500 focus:outline-none focus:ring-2 focus:ring-accent-500/20 disabled:cursor-not-allowed disabled:bg-stone-50 disabled:text-stone-400 dark:border-white/10 dark:bg-white/[0.04] dark:text-white dark:placeholder:text-stone-500 dark:disabled:bg-white/[0.02] dark:disabled:text-stone-500';
    $label = 'block text-sm font-medium text-stone-700 dark:text-stone-300';
    $error = 'mt-1 text-xs font-medium text-rose-600 dark:text-rose-400';

    $cardTitle = match (true) {
        $step === 1 => __('Data Identitas'),
        $step === 2 => __('Alamat'),
        $type === 'perusahaan' => __('Data Perusahaan & Kebutuhan'),
        default => __('Kebutuhan Pelatihan'),
    };

    $cardIcon = match (true) {
        $step === 1 => 'id-card',
        $step === 2 => 'map-pin',
        $type === 'perusahaan' => 'building-2',
        default => 'clipboard-list',
    };
@endphp

<div class="mx-auto max-w-3xl space-y-6">

    <x-tala::panel.page-header
        :title="$type === 'perusahaan'
            ? __('Permintaan Pelatihan Perusahaan')
            : __('Permintaan Pelatihan Masyarakat')"
        :subtitle="__('Lengkapi data berikut untuk mengajukan kebutuhan pelatihan kerja.')">
        <x-slot:action>
            <x-tala::panel.button :href="route('tala.panel.disnaker.status')" variant="secondary" size="sm"
                wire:navigate>
                <x-lucide-arrow-left class="size-3.5" />
                {{ __('Kembali ke dashboard') }}
            </x-tala::panel.button>
        </x-slot:action>
    </x-tala::panel.page-header>

    {{-- Langkah --}}
    <div class="flex items-center gap-2 sm:gap-4">
        @foreach ([1 => __('Identitas'), 2 => __('Alamat'), 3 => __('Kebutuhan')] as $number => $labelText)
            <div class="flex flex-1 items-center gap-2.5">
                <span
                    class="flex size-8 shrink-0 items-center justify-center rounded-full text-xs font-semibold transition
                        {{ $step >= $number ? 'bg-accent-600 text-white shadow-sm shadow-accent-600/25' : 'bg-white text-stone-400 ring-1 ring-stone-200 dark:bg-white/[0.04] dark:text-stone-500 dark:ring-white/10' }}">
                    {{ $number }}
                </span>
                <span
                    class="hidden text-xs font-semibold sm:block {{ $step >= $number ? 'text-accent-700 dark:text-accent-300' : 'text-stone-400 dark:text-stone-500' }}">
                    {{ $labelText }}
                </span>
            </div>
        @endforeach
    </div>

    @if ($wilayahError)
        <div class="rounded-2xl border border-amber-200/70 bg-amber-50 p-5 dark:border-amber-500/20 dark:bg-amber-500/10">
            <div class="flex items-start gap-3">
                <span
                    class="flex size-10 shrink-0 items-center justify-center rounded-xl border border-amber-200/70 bg-amber-100 text-amber-600 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                    <x-lucide-triangle-alert class="size-5" />
                </span>
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-amber-900 dark:text-amber-200">
                        {{ __('Data wilayah belum bisa dimuat') }}
                    </h2>
                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-300">{{ $wilayahError }}</p>

                    <x-tala::panel.button wire:click="retryWilayah" wire:loading.attr="disabled" size="sm"
                        class="mt-4">
                        <x-lucide-rotate-cw class="size-3.5" wire:loading.remove wire:target="retryWilayah" />
                        {{ $sessionExpired ? __('Masuk lagi') : __('Coba lagi') }}
                    </x-tala::panel.button>
                </div>
            </div>
        </div>
    @else
        <x-tala::panel.card :title="$cardTitle"
            :subtitle="__('Draf tersimpan otomatis saat Anda pindah langkah.')" :icon="$cardIcon">
            <div class="space-y-5">
                @if ($step === 1)
                    <div>
                        <label class="{{ $label }}" for="nik">{{ __('NIK') }}</label>
                        <input id="nik" type="text" inputmode="numeric" maxlength="16" x-mask="9999999999999999"
                            wire:model="data.nik" class="{{ $input }}" placeholder="16 digit angka">
                        @error('data.nik') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $label }}" for="whatsapp">{{ __('Nomor WhatsApp') }}</label>
                        <input id="whatsapp" type="tel" inputmode="numeric" x-mask="999999999999999"
                            wire:model="data.whatsapp" class="{{ $input }}" placeholder="08xxxxxxxxxx">
                        @error('data.whatsapp') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    <p class="rounded-xl bg-stone-50 px-4 py-3 text-xs leading-relaxed text-stone-500 dark:bg-white/[0.04] dark:text-stone-400">
                        {{ __('NIK dan nomor WhatsApp disimpan terenkripsi dan hanya dipakai Dinas Tenaga Kerja untuk menghubungi Anda.') }}
                    </p>
                @endif

                @if ($step === 2)
                    @foreach ([
        'ktp' => __('Alamat sesuai KTP'),
        'domisili' => __('Alamat Domisili'),
    ] as $prefix => $sectionLabel)
                        @if ($prefix === 'domisili')
                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-xl border border-stone-200 bg-stone-50/60 p-3.5 transition hover:bg-stone-100/60 dark:border-white/10 dark:bg-white/[0.03] dark:hover:bg-white/[0.06]">
                                <input type="checkbox" wire:model.live="sameAsKtp"
                                    class="mt-0.5 size-4 rounded border-stone-300 text-accent-600 focus:ring-2 focus:ring-accent-500/30 dark:border-white/20 dark:bg-white/[0.06] dark:focus:ring-offset-stone-900">
                                <span class="text-sm font-medium text-stone-700 dark:text-stone-300">
                                    {{ __('Alamat domisili sama dengan alamat KTP') }}
                                    <span class="mt-0.5 block text-xs font-normal text-stone-500 dark:text-stone-400">
                                        {{ __('Centang untuk menyalin alamat KTP ke domisili.') }}
                                    </span>
                                </span>
                            </label>
                        @endif

                        @if ($prefix === 'domisili' && $sameAsKtp)
                            <div
                                class="space-y-2 {{ $loop->last ? '' : 'border-b border-stone-100 pb-5 dark:border-white/[0.06]' }}">
                                <h3 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                                    {{ $sectionLabel }}
                                </h3>
                                <p class="rounded-xl bg-stone-50 px-4 py-3 text-xs leading-relaxed text-stone-500 dark:bg-white/[0.04] dark:text-stone-400">
                                    {{ __('Alamat domisili mengikuti alamat KTP.') }}
                                </p>
                            </div>
                        @else
                            <div
                                class="space-y-4 {{ $loop->last ? '' : 'border-b border-stone-100 pb-5 dark:border-white/[0.06]' }}">
                                <h3 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                                    {{ $sectionLabel }}
                                </h3>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="{{ $label }}">{{ __('Kecamatan') }}</label>
                                        <x-tala::panel.select wire:model.live="data.{{ $prefix }}_district_code"
                                            class="mt-1">
                                            <option value="">{{ __('Pilih kecamatan') }}</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district['code'] }}">{{ $district['name'] }}</option>
                                            @endforeach
                                        </x-tala::panel.select>
                                        @error('data.' . $prefix . '_district_code') <p class="{{ $error }}">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="{{ $label }}">{{ __('Desa / Kelurahan') }}</label>
                                        <x-tala::panel.select wire:model.live="data.{{ $prefix }}_village_code"
                                            class="mt-1" :disabled="empty($villages[$prefix])">
                                            <option value="">{{ __('Pilih desa/kelurahan') }}</option>
                                            @foreach ($villages[$prefix] as $village)
                                                <option value="{{ $village['code'] }}">{{ $village['name'] }}</option>
                                            @endforeach
                                        </x-tala::panel.select>
                                        @error('data.' . $prefix . '_village_code') <p class="{{ $error }}">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="{{ $label }}">{{ __('Alamat lengkap') }}</label>
                                    <textarea wire:model="data.{{ $prefix }}_address" rows="2" class="{{ $input }}"
                                        placeholder="{{ __('Jalan, RT/RW, dusun') }}"></textarea>
                                    @error('data.' . $prefix . '_address') <p class="{{ $error }}">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                @if ($step === 3 && $type === 'perusahaan')
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="{{ $label }}">{{ __('Nama perusahaan') }}</label>
                            <input type="text" wire:model="data.nama_perusahaan" class="{{ $input }}">
                            @error('data.nama_perusahaan') <p class="{{ $error }}">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="{{ $label }}">{{ __('Bidang usaha') }}</label>
                            <input type="text" wire:model="data.bidang_usaha" class="{{ $input }}">
                            @error('data.bidang_usaha') <p class="{{ $error }}">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="{{ $label }}">{{ __('Alamat perusahaan') }}</label>
                        <textarea wire:model="data.alamat_usaha" rows="2" class="{{ $input }}"></textarea>
                        @error('data.alamat_usaha') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $label }}">{{ __('Jumlah tenaga kerja yang dibutuhkan') }}</label>
                        <input type="number" min="1" wire:model="data.jumlah_tenaga_kerja" class="{{ $input }}">
                        @error('data.jumlah_tenaga_kerja') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>
                @endif

                @if ($step === 3)
                    @if ($type === 'masyarakat')
                        <div>
                            <label class="{{ $label }}">{{ __('Pekerjaan saat ini') }}</label>
                            <input type="text" wire:model="data.pekerjaan" class="{{ $input }}"
                                placeholder="{{ __('Contoh: belum bekerja, buruh, wirausaha') }}">
                            @error('data.pekerjaan') <p class="{{ $error }}">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div>
                        <label class="{{ $label }}">
                            {{ $type === 'perusahaan' ? __('Kompetensi teknis yang dibutuhkan') : __('Kebutuhan pelatihan') }}
                        </label>
                        <textarea wire:model="data.kebutuhan" rows="4" class="{{ $input }}"
                            placeholder="{{ $type === 'perusahaan' ? __('Contoh: operator mesin bubut, pengelasan SMAW, instalasi listrik 3 fase') : __('Pelatihan apa yang dibutuhkan dan untuk siapa') }}"></textarea>
                        @error('data.kebutuhan') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $label }}">{{ __('Keterangan tambahan') }}
                            <span class="text-stone-400 dark:text-stone-500">({{ __('opsional') }})</span></label>
                        <textarea wire:model="data.keterangan" rows="2" class="{{ $input }}"></textarea>
                        @error('data.keterangan') <p class="{{ $error }}">{{ $message }}</p> @enderror
                    </div>

                    @error('submit')
                        <p class="rounded-xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                            {{ $message }}
                        </p>
                    @enderror
                @endif
            </div>

            <x-slot:footer>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-3">
                        @if ($step > 1)
                            <x-tala::panel.button variant="secondary" wire:click="back">
                                <x-lucide-arrow-left class="size-4" />
                                {{ __('Kembali') }}
                            </x-tala::panel.button>
                        @endif

                        <x-tala::panel.button variant="danger" size="sm" wire:click="restart"
                            wire:confirm="{{ __('Hapus draf dan mulai dari awal?') }}">
                            {{ __('Mulai ulang') }}
                        </x-tala::panel.button>
                    </div>

                    @if ($step < 3)
                        <x-tala::panel.button wire:click="next" wire:loading.attr="disabled">
                            {{ __('Lanjut') }}
                            <x-lucide-arrow-right class="size-4" />
                        </x-tala::panel.button>
                    @else
                        <x-tala::panel.button wire:click="submit" wire:loading.attr="disabled">
                            <x-lucide-send class="size-4" wire:loading.remove wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Kirim Permintaan') }}</span>
                            <span wire:loading wire:target="submit">{{ __('Mengirim...') }}</span>
                        </x-tala::panel.button>
                    @endif
                </div>
            </x-slot:footer>
        </x-tala::panel.card>
    @endif
</div>
