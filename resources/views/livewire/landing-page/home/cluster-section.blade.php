@php
    $summary = $summary ?? null;
    $section = $section ?? null;
    $clusters = $summary['clusters'] ?? [];
    $max = $clusters ? max(array_column($clusters, 'count')) : 1;
    $masyarakatShare = $summary && $summary['total'] > 0
        ? $summary['masyarakat'] / $summary['total'] * 100
        : 0;
    $title = $section?->meta('title', 'Usulan pelatihan yang paling banyak masuk');
    $subtitle = $section?->meta('subtitle', 'Aspirasi warga dan perusahaan yang sudah dikelompokkan dan disetujui Dinas Tenaga Kerja.');
@endphp

<div>
@if ($section && $summary && $clusters)
    <section id="kebutuhan-pelatihan" class="py-20 bg-slate-50 dark:bg-slate-950">
        <style>
            .js-bars .cluster-bar {
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 700ms cubic-bezier(.22, .61, .36, 1);
            }

            .js-bars.cluster-bars-visible .cluster-bar {
                transform: scaleX(1);
            }

            @media (prefers-reduced-motion: reduce) {
                .js-bars .cluster-bar {
                    transform: none;
                    transition: none;
                }
            }
        </style>

        <div class="container max-w-7xl mx-auto px-4" data-aos="fade-up">

            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h2>
                @if ($subtitle)
                    <p class="mt-3 text-gray-600 dark:text-slate-400">
                        {{ $subtitle }}
                    </p>
                @endif
                <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">
                    Banyaknya usulan tidak menentukan program yang dipilih.
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:gap-6 lg:grid-cols-12">

                {{-- Angka besar = total aspirasi, bukan klaster pemenang --}}
                <div class="flex flex-col rounded-2xl bg-teal-700 p-6 text-white sm:p-8 lg:col-span-5 lg:self-start">
                    <p class="text-xs font-semibold uppercase tracking-wider text-teal-100/80">
                        Aspirasi warga &amp; perusahaan
                    </p>

                    <p class="mt-5 flex items-baseline gap-2">
                        <span class="text-6xl font-bold leading-none tabular-nums sm:text-7xl lg:text-8xl">{{ number_format($summary['total'], 0, ',', '.') }}</span>
                        <span class="text-sm text-teal-50/80">usulan</span>
                    </p>
                    <p class="mt-2 text-sm text-teal-50/80">
                        terkumpul pada {{ $summary['period_label'] }}
                    </p>

                    <div class="mt-auto border-t border-white/15 pt-6">                        <p class="text-sm leading-relaxed text-teal-50/85">
                            Dikelompokkan menjadi {{ count($clusters) }} klaster berdasarkan kesamaan kebutuhan pelatihan.
                        </p>

                        <div class="mt-5 flex h-1.5 overflow-hidden rounded-full bg-white/20" aria-hidden="true">
                            <div class="bg-white" style="width: {{ round($masyarakatShare) }}%"></div>
                            <div class="flex-1 bg-teal-300"></div>
                        </div>
                        <p class="mt-2 text-xs text-teal-50/80">
                            {{ number_format($summary['masyarakat'], 0, ',', '.') }} warga ·
                            {{ number_format($summary['perusahaan'], 0, ',', '.') }} perusahaan
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-800 sm:p-8 lg:col-span-7">
                    <div class="flex items-baseline justify-between gap-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Usulan per klaster</h3>
                        <span class="text-xs text-gray-500 dark:text-slate-400">{{ count($clusters) }} klaster</span>
                    </div>

                    <ol id="cluster-list" class="mt-6 space-y-5">
                        @foreach ($clusters as $cluster)
                            <li>
                                <div class="flex items-baseline gap-3">
                                    <span class="w-5 shrink-0 text-xs font-semibold tabular-nums text-gray-400 dark:text-slate-500">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="min-w-0 flex-1 truncate text-sm font-medium text-gray-800 dark:text-slate-200">{{ $cluster['name'] }}</span>
                                    <span class="shrink-0 text-sm font-bold tabular-nums text-gray-900 dark:text-white">{{ $cluster['count'] }}</span>
                                </div>
                                <div class="mt-2 pl-8">
                                    <div class="h-2 overflow-hidden rounded-full bg-gray-200 dark:bg-slate-800" aria-hidden="true">
                                        <div class="cluster-bar h-full rounded-full bg-teal-600 dark:bg-teal-500"
                                            style="width: {{ round($cluster['count'] / $max * 100) }}%; transition-delay: {{ $loop->index * 55 }}ms"></div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-4 border-t border-gray-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                <div class="max-w-2xl space-y-1">
                    <p class="text-xs text-gray-500 dark:text-slate-400">
                        Klaster disusun dari hasil analisis Gemini AI
                        @if ($summary['analysed_at'])
                            · analisis terakhir {{ $summary['analysed_at'] }}
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 dark:text-slate-400">
                        Hasil analisis bersifat penilaian awal.
                    </p>
                    @unless ($summary['is_active_period'])
                        <p class="text-xs text-gray-500 dark:text-slate-400">
                            Periode aktif belum punya klaster yang disetujui, jadi yang ditampilkan periode sebelumnya.
                        </p>
                    @endunless
                </div>

                <a href="{{ route('disnaker.pelatihan.index') }}" wire:navigate
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                    Ajukan kebutuhan pelatihan
                </a>
            </div>
        </div>

        <script>
            (function () {
                var list = document.getElementById('cluster-list');

                // Tanpa IntersectionObserver, atau daftar sudah terlihat saat load:
                // bar langsung tampil penuh, animasi dilewati.
                if (!list || !('IntersectionObserver' in window) || list.classList.contains('js-bars')) {
                    return;
                }

                var show = function () {
                    list.classList.add('cluster-bars-visible');
                };

                if (list.getBoundingClientRect().top < window.innerHeight) {
                    return;
                }

                list.classList.add('js-bars');

                var observer = new IntersectionObserver(function (entries) {
                    if (!entries[0].isIntersecting) {
                        return;
                    }

                    show();
                    observer.disconnect();
                }, { threshold: 0.15 });

                observer.observe(list);

                // Jaring pengaman: bar tidak boleh tetap tersembunyi kalau observer terlewat.
                setTimeout(show, 4000);
            })();
        </script>
    </section>
@endif
</div>
