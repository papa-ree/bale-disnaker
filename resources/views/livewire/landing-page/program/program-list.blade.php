<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    <x-bale-disnaker::header-page
        title="Program Pelatihan"
        subtitle="Program yang sudah ditetapkan Dinas Tenaga Kerja dari usulan warga dan perusahaan."
        :breadcrumbs="[['label' => 'Program Pelatihan']]" />

    <section class="py-12 md:py-16">
        <div class="container mx-auto max-w-7xl px-4">

            @if (empty($programs))
                <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Belum ada program yang ditetapkan</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm text-gray-600 dark:text-slate-400">
                        Program pelatihan akan muncul di sini setelah Dinas Tenaga Kerja menetapkannya.
                    </p>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                    @foreach ($programs as $program)
                        <article class="flex flex-col rounded-2xl bg-white p-6 ring-1 ring-gray-200 dark:bg-slate-800 dark:ring-slate-700">
                            <span class="text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">
                                Kuartal {{ $program['quarter'] }} · {{ $program['year'] }}
                            </span>
                            <h2 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">
                                {{ $program['name'] }}
                            </h2>
                            @if ($program['cluster'])
                                <p class="mt-auto pt-4 text-sm text-gray-600 dark:text-slate-400">
                                    Dari klaster: {{ $program['cluster'] }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif

            <p class="mt-8 text-xs text-gray-500 dark:text-slate-400">
                Jadwal dan cara pendaftaran diumumkan terpisah oleh Dinas Tenaga Kerja.
            </p>
        </div>
    </section>
</div>
