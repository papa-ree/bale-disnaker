<div class="space-y-6">

    <x-tala::panel.page-header :title="__('Riwayat Permintaan')"
        :subtitle="__('Semua permintaan pelatihan yang pernah Anda kirim, lintas periode.')" />

    <x-tala::panel.card body-class="p-0">
        @forelse ($submissions as $submission)
            <div
                class="flex flex-col gap-3 border-b border-stone-100 px-5 py-4 last:border-0 dark:border-white/[0.06] sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-stone-900 dark:text-white">
                        {{ $submission->period?->name ?? __('Periode dihapus') }}
                        <span class="font-normal text-stone-500 dark:text-stone-400">({{ $submission->period?->year }})</span>
                    </p>
                    <p class="mt-0.5 text-xs text-stone-500 dark:text-stone-400">
                        {{ ucfirst($submission->type) }} · {{ __('dikirim') }}
                        {{ $submission->submitted_at?->format('d M Y') ?? '—' }}
                        @if ($submission->cluster)
                            · {{ __('Klaster') }}: {{ $submission->cluster->name }}
                        @endif
                    </p>
                </div>

                <x-tala::panel.badge :tone="$submission->status === 'AI_Processed' ? 'success' : 'warning'" dot
                    class="w-fit shrink-0">
                    {{ $submission->status_label }}
                </x-tala::panel.badge>
            </div>
        @empty
            <x-tala::panel.empty-state icon="history" :title="__('Belum ada riwayat permintaan.')"
                :description="__('Permintaan yang Anda kirim akan muncul di sini.')" />
        @endforelse
    </x-tala::panel.card>

    @if ($submissions->hasPages())
        <div>{{ $submissions->links() }}</div>
    @endif
</div>
