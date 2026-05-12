<div class="min-h-screen bg-gray-50 dark:bg-slate-900 pt-32 pb-20">
    <div class="container mx-auto px-4">
        {{-- Breadcrumb --}}
        <div class="max-w-6xl mx-auto mb-8">
            <a href="{{ route('bale.jobs') }}" wire:navigate.hover
                class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-teal-600 transition-colors">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Kembali ke Lowongan
            </a>
        </div>

        @if ($job)
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Header Card --}}
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $job->nama_pekerjaan }}
                                </h1>
                                <div class="text-xl text-teal-600 dark:text-teal-400 font-medium mb-4">
                                    {{ $job->nama_perusahaan }}
                                </div>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                                    @if ($job->lokasi)
                                        <div class="flex items-center gap-1.5">
                                            <x-lucide-map-pin class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                            {{ $job->lokasi }}
                                        </div>
                                    @endif
                                    @if ($job->tipe)
                                        <div class="flex items-center gap-1.5">
                                            <x-lucide-briefcase class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                            {{ $job->tipe }}
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-1.5">
                                        <x-lucide-clock class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                        {{ \Carbon\Carbon::parse($job->updated_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons for Mobile --}}
                            @if (!empty($job->url_perusahaan))
                                <div class="flex md:hidden flex-col gap-3">
                                    <a href="{{ str_starts_with($job->url_perusahaan, 'http') ? $job->url_perusahaan : 'https://' . $job->url_perusahaan }}"
                                        target="_blank"
                                        class="w-full py-3 bg-teal-600 text-white text-center rounded-xl font-semibold">
                                        Lamar Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Job Description --}}
                    @if (!empty($job->deskripsi_pekerjaan))
                        <div
                            class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Deskripsi Pekerjaan</h2>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $job->deskripsi_pekerjaan }}
                            </p>
                        </div>
                    @endif

                    {{-- Persyaratan & Kualifikasi (EditorJS) --}}
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Persyaratan & Kualifikasi</h2>
                        @if (!empty($job->persyaratan_kualifikasi))
                            @php
                                $editorData = is_string($job->persyaratan_kualifikasi)
                                    ? json_decode($job->persyaratan_kualifikasi, true)
                                    : $job->persyaratan_kualifikasi;
                                $hasBlocks = !empty($editorData['blocks'] ?? []);
                            @endphp
                            @if ($hasBlocks)
                                <x-emperan::editorjs-renderer :content="$job->persyaratan_kualifikasi" />
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Belum ada persyaratan yang ditambahkan.</p>
                            @endif
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">Belum ada persyaratan yang ditambahkan.</p>
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Job Overview --}}
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 sticky top-32">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-6">Ringkasan Pekerjaan</h3>

                        <div class="space-y-5">
                            {{-- Gaji --}}
                            @if (!empty($job->gaji))
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center shrink-0">
                                        <x-lucide-coins class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Gaji</div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $job->gaji }}</div>
                                    </div>
                                </div>
                            @endif

                            {{-- Kategori --}}
                            @if (!empty($job->kategory))
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
                                        <x-lucide-tag class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Kategori</div>
                                        <div class="font-semibold text-gray-900 dark:text-white capitalize">{{ $job->kategory }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Tipe --}}
                            @if (!empty($job->tipe))
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center shrink-0">
                                        <x-lucide-briefcase class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Tipe</div>
                                        <div class="font-semibold text-gray-900 dark:text-white capitalize">{{ $job->tipe }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Batas Waktu --}}
                            @if (!empty($job->tgl_berakhir))
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center shrink-0">
                                        <x-lucide-calendar-x class="w-5 h-5 text-red-600 dark:text-red-400" />
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Batas Lamaran</div>
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($job->tgl_berakhir)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Ditayangkan --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center shrink-0">
                                    <x-lucide-calendar class="w-5 h-5 text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Ditayangkan</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cara Melamar --}}
                        @if (!empty($job->apply))
                            <div class="border-t border-gray-100 dark:border-slate-700 my-6 pt-6">
                                <h4 class="font-bold text-gray-900 dark:text-white mb-4">Cara Melamar</h4>
                                <div
                                    class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl leading-relaxed whitespace-pre-wrap wrap-break-word">
                                    @php
                                        $applyText = e(trim($job->apply));
                                        $applyText = preg_replace_callback(
                                            '/(https?:\/\/[^\s]+|bit\.ly\/[^\s]+|www\.[^\s]+)/i',
                                            fn($m) => '<a href="' . (str_starts_with(strtolower($m[0]), 'http') ? $m[0] : 'https://' . $m[0]) . '" target="_blank" class="underline decoration-wavy decoration-teal-500 hover:text-teal-600 transition-colors">' . $m[0] . '</a>',
                                            $applyText
                                        );
                                    @endphp
                                    {!! $applyText !!}
                                </div>
                            </div>
                        @endif

                        {{-- Apply Button --}}
                        @if (!empty($job->url_perusahaan))
                            <div class="mt-6">
                                <a href="{{ str_starts_with($job->url_perusahaan, 'http') ? $job->url_perusahaan : 'https://' . $job->url_perusahaan }}"
                                    target="_blank"
                                    class="w-full block py-3 bg-teal-600 hover:bg-teal-700 text-white text-center rounded-xl font-semibold transition-colors shadow-lg shadow-teal-600/20">
                                    Lamar Sekarang
                                </a>
                            </div>
                        @endif

                        {{-- Company Info --}}
                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Tentang {{ $job->nama_perusahaan }}
                            </h4>
                            @if (!empty($job->deskripsi_perusahaan))
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                    {{ $job->deskripsi_perusahaan }}
                                </p>
                            @endif
                            {{-- @if (!empty($job->url_perusahaan))
                            @php
                            $domain = parse_url((str_starts_with($job->url_perusahaan, 'http') ? '' : 'http://') .
                            $job->url_perusahaan, PHP_URL_HOST);
                            $domain = preg_replace('/^www\./', '', $domain);
                            @endphp
                            <a href="{{ 'https://' . $domain }}" target="_blank"
                                class="inline-flex items-center gap-1.5 mt-3 text-sm text-teal-600 dark:text-teal-400 hover:underline">
                                <x-lucide-external-link class="w-4 h-4" />
                                Kunjungi {{ $job->nama_perusahaan }}
                            </a>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Not Found --}}
            <div class="max-w-6xl mx-auto text-center py-24">
                <div
                    class="w-24 h-24 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-lucide-search class="text-gray-400 w-10 h-10" />
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Lowongan Tidak Ditemukan</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Lowongan yang Anda cari tidak tersedia atau sudah ditutup.
                </p>
                <a href="{{ route('bale.jobs') }}" wire:navigate
                    class="inline-flex px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-colors">
                    Lihat Lowongan Lain
                </a>
            </div>
        @endif
    </div>
</div>