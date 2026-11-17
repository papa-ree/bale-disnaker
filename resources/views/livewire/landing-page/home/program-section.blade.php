@if (! empty($programs))
    <section id="program-pelatihan" class="py-20 bg-white dark:bg-slate-900">
        <div class="container max-w-7xl mx-auto px-4" data-aos="fade-up">
            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                    Program pelatihan yang sudah ditetapkan
                </h2>
                <p class="mt-3 text-gray-600 dark:text-slate-400">
                    Program yang diputuskan Dinas Tenaga Kerja dari usulan warga dan perusahaan.
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:gap-6 sm:grid-cols-2">
                @foreach ($programs as $program)
                    <article class="flex flex-col rounded-2xl bg-slate-50 p-6 ring-1 ring-gray-200 dark:bg-slate-800 dark:ring-slate-700">
                        <span class="text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">
                            Kuartal {{ $program['quarter'] }} · {{ $program['year'] }}
                        </span>
                        <h3 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">
                            {{ $program['name'] }}
                        </h3>
                        @if ($program['cluster'])
                            <p class="mt-auto pt-4 text-sm text-gray-600 dark:text-slate-400">
                                Dari klaster: {{ $program['cluster'] }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col gap-4 border-t border-gray-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-500 dark:text-slate-400">
                    Jadwal dan cara pendaftaran diumumkan terpisah oleh Dinas Tenaga Kerja.
                </p>

                <a href="{{ route('bale.programs') }}" wire:navigate.hover
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Lihat semua program
                </a>
            </div>
        </div>
    </section>
@endif
