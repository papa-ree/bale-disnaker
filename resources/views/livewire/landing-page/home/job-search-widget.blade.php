@if($actived)
    <section class="py-20 bg-linear-to-b from-white to-gray-50 dark:from-slate-900 dark:to-slate-800">
        <div data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    @if (empty($section) || empty($this->meta))
                        <x-emperan::section-error title="Widget Pencarian Lowongan Belum Dikonfigurasi"
                            message="Silakan konfigurasi section 'job-widget-section' di panel admin CMS agar fungsionalitas pencarian kerja dapat ditampilkan." />
                    @else
                        @php
                            $meta = $this->meta;
                            $stats = $this->stats;
                            $categories = $this->categories;
                        @endphp

                        <div class="text-center mb-10">
                            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $meta['title'] ?? 'Cari Lowongan Kerja' }}
                            </h2>
                            @if (!empty($meta['subtitle']))
                                <p class="text-lg text-gray-600 dark:text-gray-400">
                                    {{ $meta['subtitle'] }}
                                </p>
                            @endif
                        </div>

                        <form wire:submit.prevent="search"
                            class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 md:p-8 border border-gray-100 dark:border-slate-700">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <div class="flex-1 items-center relative">
                                    <input type="text" wire:model="keyword"
                                        placeholder="{{ $meta['custom']['search_placeholder'] ?? 'Cari lowongan kerja...' }}"
                                        class="w-full pl-12 h-14 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>

                                <div class="relative lg:w-64">
                                    <x-lucide-map-pin class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" />
                                    <input type="text" placeholder="Ponorogo" disabled
                                        class="w-full pl-12 h-14 text-base bg-gray-50 dark:bg-slate-900/50 border-gray-200 dark:border-slate-700 rounded-md dark:text-gray-400 focus:border-teal-500 focus:ring-teal-500" />
                                </div>

                                <button type="submit" wire:loading.attr="disabled"
                                    class="h-14 px-8 cursor-pointer bg-teal-600 hover:bg-teal-700 disabled:bg-teal-800 text-white font-semibold text-base rounded-lg transition-all flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="search">
                                        {{ $meta['buttons'][0]['label'] ?? 'Cari Lowongan' }}
                                    </span>
                                    <span wire:loading wire:target="search">
                                        Memuat...
                                    </span>
                                    <svg wire:loading wire:target="search" class="animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            @if (!empty($categories))
                                <div class="mt-6 flex flex-wrap gap-2 text-center md:text-left justify-center md:justify-start">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 w-full md:w-auto mb-2 md:mb-0">Pencarian
                                        populer:</span>
                                    @foreach ($categories as $cat)
                                        <button type="button" wire:click="searchCategory('{{ $cat }}')"
                                            class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 text-gray-700 dark:text-gray-300 rounded-full text-sm transition-colors">
                                            {{ $cat }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </form>

                        {{-- Quick Stats --}}
                        @if (!empty($stats))
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                                @foreach ($stats as $index => $stat)
                                    @php
                                        $colors = [
                                            'text-teal-600 dark:text-teal-400',
                                            'text-blue-600 dark:text-blue-400',
                                            'text-green-600 dark:text-green-400',
                                            'text-purple-600 dark:text-purple-400',
                                        ];
                                        $colorClass = $colors[$index % count($colors)];
                                    @endphp
                                    <div
                                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md text-center border border-gray-100 dark:border-slate-700">
                                        <div class="text-3xl font-bold {{ $colorClass }} mb-1">{{ $stat['value'] }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $stat['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Latest Jobs --}}
                        @if (!empty($this->latestJobs) && $this->latestJobs->count() > 0)
                            <div class="mt-10">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lowongan Terbaru</h3>
                                    <a href="{{ route('bale.jobs') }}" wire:navigate.hover
                                        class="text-sm text-teal-600 dark:text-teal-400 hover:underline font-medium inline-flex items-center gap-1">
                                        Lihat Semua
                                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    @foreach ($this->latestJobs as $latestJob)
                                        <a href="{{ route('bale.view-job', $latestJob->slug) }}" wire:navigate.hover
                                            class="group flex items-center justify-between bg-white dark:bg-slate-800 rounded-xl px-5 py-4 border border-gray-100 dark:border-slate-700 hover:border-teal-400 dark:hover:border-teal-500 hover:shadow-md transition-all duration-200">
                                            <div class="flex items-center gap-4 min-w-0">
                                                {{-- Icon placeholder --}}
                                                <div class="w-10 h-10 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center shrink-0">
                                                    <x-lucide-briefcase class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 dark:text-white text-sm truncate group-hover:text-teal-700 dark:group-hover:text-teal-400 transition-colors">
                                                        {{ $latestJob->nama_pekerjaan }}
                                                    </p>
                                                    <div class="flex items-center gap-3 mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                        <span class="truncate">{{ $latestJob->nama_perusahaan }}</span>
                                                        @if ($latestJob->lokasi)
                                                            <span class="flex items-center gap-1 shrink-0">
                                                                <x-lucide-map-pin class="w-3 h-3" />
                                                                {{ $latestJob->lokasi }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 shrink-0 ml-4">
                                                @if ($latestJob->tipe)
                                                    <span class="hidden sm:inline-flex px-2.5 py-1 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 rounded-full text-xs font-medium capitalize">
                                                        {{ $latestJob->tipe }}
                                                    </span>
                                                @endif
                                                <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($latestJob->created_at)->diffForHumans() }}
                                                </span>
                                                <x-lucide-chevron-right class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-teal-500 transition-colors" />
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif