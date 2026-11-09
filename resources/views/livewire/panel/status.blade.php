<div class="space-y-6">

    <x-tala::panel.page-header :title="__('Pelatihan')"
        :subtitle="__('Ajukan permintaan pelatihan dan pantau statusnya di sini.')">
        <x-slot:action>
            <x-tala::panel.badge :tone="$period ? 'info' : 'neutral'" dot>
                <x-lucide-calendar-range class="size-3.5" />
                @if ($period)
                    {{ $period->name }} · {{ $period->year }}
                @else
                    {{ __('Belum ada periode aktif') }}
                @endif
            </x-tala::panel.badge>
        </x-slot:action>
    </x-tala::panel.page-header>

    <x-tala::panel.card :title="__('Status Permintaan')"
        :subtitle="__('Satu permintaan per akun untuk setiap periode.')" icon="inbox">
        @if (! $period)
            <x-tala::panel.empty-state icon="calendar-x" :title="__('Belum ada periode pelatihan yang dibuka.')"
                :description="__('Silakan cek kembali nanti.')" />
        @elseif ($submission)
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                        {{ __('Jenis') }}
                    </dt>
                    <dd class="mt-1 text-sm font-medium text-stone-900 dark:text-white">{{ ucfirst($submission->type) }}</dd>
                </div>

                @if ($submission->cluster)
                    <div>
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                            {{ __('Klaster') }}
                        </dt>
                        <dd class="mt-1 text-sm font-medium text-stone-900 dark:text-white">
                            {{ $submission->cluster->name }}
                            @if ($submission->cluster->sub_category)
                                <span class="mt-0.5 block text-xs font-normal text-stone-500 dark:text-stone-400">
                                    {{ $submission->cluster->sub_category }}
                                </span>
                            @endif
                        </dd>
                    </div>
                @endif

                <div>
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                        {{ __('Status') }}
                    </dt>
                    <dd class="mt-1">
                        <x-tala::panel.badge :tone="$submission->status === 'AI_Processed' ? 'success' : 'warning'" dot>
                            {{ $submission->status_label }}
                        </x-tala::panel.badge>
                    </dd>
                </div>

                <div>
                    <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-400 dark:text-stone-500">
                        {{ __('Dikirim') }}
                    </dt>
                    <dd class="mt-1 text-sm text-stone-900 dark:text-white">
                        {{ $submission->submitted_at?->format('d M Y') ?? '—' }}
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
