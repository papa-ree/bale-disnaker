<x-tala::panel.card :title="__('Data Kependudukan')"
    :subtitle="__('Dipakai Dinas Tenaga Kerja untuk menghubungi Anda terkait permintaan pelatihan.')" icon="id-card">
    <dl class="divide-y divide-stone-100 dark:divide-white/[0.06]">
        <div class="flex items-start justify-between gap-4 py-3 first:pt-0 last:pb-0">
            <dt class="text-sm text-stone-500 dark:text-stone-400">{{ __('NIK') }}</dt>
            <dd class="text-right font-mono text-sm text-stone-900 dark:text-stone-100">{{ $nik ?? '—' }}</dd>
        </div>

        <div class="flex items-start justify-between gap-4 py-3 first:pt-0 last:pb-0">
            <dt class="text-sm text-stone-500 dark:text-stone-400">{{ __('WhatsApp') }}</dt>
            <dd class="text-right text-sm text-stone-900 dark:text-stone-100">{{ $whatsapp ?? '—' }}</dd>
        </div>
    </dl>
</x-tala::panel.card>
