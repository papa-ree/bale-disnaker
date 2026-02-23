@if($actived)
    <section class="py-20 bg-linear-to-b from-white to-gray-50 dark:from-slate-900 dark:to-slate-800">
        <div data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    @if (empty($section) || empty($this->meta))
                        <x-emperan::section-error
                            title="Job Search Widget Not Configured"
                            message="Silakan konfigurasi section 'job-widget-section' di panel admin CMS agar fungsionalitas pencarian kerja dapat ditampilkan."
                        />
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

                                <button type="submit"
                                    class="h-14 px-8 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-base rounded-lg transition-colors">
                                    {{ $meta['buttons'][0]['label'] ?? 'Search Jobs' }}
                                </button>
                            </div>

                            @if (!empty($categories))
                                <div class="mt-6 flex flex-wrap gap-2 text-center md:text-left justify-center md:justify-start">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 w-full md:w-auto mb-2 md:mb-0">Popular searches:</span>
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
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif