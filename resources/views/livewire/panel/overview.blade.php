<div class="space-y-6">

    <x-tala::panel.page-header
        :title="__('Selamat datang, :name', ['name' => auth('tala')->user()?->name ?? __('warga')])"
        :subtitle="__('Ringkasan permintaan pelatihan Anda.')" />

    <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
        <x-tala::panel.stat :label="__('Total permintaan')" :value="$total" icon="inbox"
            :hint="__('Semua periode')" :href="route('tala.panel.disnaker.riwayat')" wire:navigate />

        <x-tala::panel.stat :label="__('Sudah diproses')" :value="$processed" icon="calendar-check" tone="success"
            :hint="__('Selesai dianalisis')" :href="route('tala.panel.disnaker.riwayat')" wire:navigate />

        <x-tala::panel.stat :label="__('Sedang diproses')" :value="$pending" icon="clock" tone="warning"
            :hint="__('Menunggu analisis')" :href="route('tala.panel.disnaker.riwayat')" wire:navigate />

        <x-tala::panel.stat :label="__('Periode aktif')" :value="$period?->name ?? '—'" icon="calendar-range"
            tone="info" :hint="$period?->year" :href="$period ? route('tala.panel.disnaker.status') : null"
            wire:navigate />
    </div>

    <x-tala::panel.card :title="__('Permintaan periode ini')"
        :subtitle="$period ? $period->name.' · '.$period->year : __('Belum ada periode aktif')" icon="clipboard-list">
        @if ($current)
            <x-slot:actions>
                <x-tala::panel.badge :tone="$current->status === 'AI_Processed' ? 'success' : 'warning'" dot>
                    {{ $current->status_label }}
                </x-tala::panel.badge>
            </x-slot:actions>
        @endif

        @if (! $period)
            <x-tala::panel.empty-state icon="calendar-x" :title="__('Belum ada periode pelatihan yang dibuka.')"
                :description="__('Silakan cek kembali nanti.')" />
        @elseif ($current)
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                        {{ __('Jenis') }}
                    </dt>
                    <dd class="mt-1 text-sm font-medium text-stone-900 dark:text-white">{{ ucfirst($current->type) }}</dd>
                </div>

                @if ($current->cluster)
                    <div>
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                            {{ __('Klaster') }}
                        </dt>
                        <dd class="mt-1 text-sm font-medium text-stone-900 dark:text-white">
                            {{ $current->cluster->name }}
                            @if ($current->cluster->sub_category)
                                <span class="mt-0.5 block text-xs font-normal text-stone-500 dark:text-stone-400">
                                    {{ $current->cluster->sub_category }}
                                </span>
                            @endif
                        </dd>
                    </div>
                @endif

                <div>
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                        {{ __('Dikirim') }}
                    </dt>
                    <dd class="mt-1 text-sm text-stone-900 dark:text-white">
                        {{ $current->submitted_at?->format('d M Y') ?? '—' }}
                    </dd>
                </div>
            </dl>
        @else
            <x-tala::panel.empty-state icon="file-plus" :title="__('Anda belum mengirim permintaan pada periode ini.')"
                :description="__('Isi formulir permintaan pelatihan pada periode ini.')">
                <x-slot:action>
                    <x-tala::panel.button :href="route('disnaker.pelatihan.masyarakat')" wire:navigate>
                        {{ __('Formulir Masyarakat') }}
                        <x-lucide-arrow-right class="size-3.5" />
                    </x-tala::panel.button>

                    <x-tala::panel.button :href="route('disnaker.pelatihan.perusahaan')" variant="secondary"
                        wire:navigate>
                        {{ __('Formulir Perusahaan') }}
                        <x-lucide-arrow-right class="size-3.5" />
                    </x-tala::panel.button>
                </x-slot:action>
            </x-tala::panel.empty-state>
        @endif
    </x-tala::panel.card>
</div>
