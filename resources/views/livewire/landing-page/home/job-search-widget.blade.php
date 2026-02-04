<section class="py-20 bg-linear-to-b from-white to-gray-50 dark:from-slate-900 dark:to-slate-800">
    <div data-aos="fade-up">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                @if(!empty($section))
                    <div class="text-center mb-10">
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $section['meta']['title'] ?? 'Cari Lowongan Kerja' }}
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            {{ $section['meta']['subtitle'] ?? 'Cari lowongan kerja di Ponorogo' }}
                        </p>
                    </div>

                    <form wire:submit.prevent="search"
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 md:p-8 border border-gray-100 dark:border-slate-700">
                        <div class="flex flex-col lg:flex-row gap-4">
                            {{-- <div class="flex-1 relative">
                                <x-lucide-search class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" />
                                <input type="text" placeholder="Job title, keywords, or company..." wire:model="keyword"
                                    class="w-full pl-12 h-14 text-base bg-white dark:bg-slate-900 border-gray-200 dark:border-slate-700 focus:border-teal-500 focus:ring-teal-500 rounded-md dark:text-white" />
                            </div> --}}

                            <div class="flex-1 items-center relative">
                                <input type="text" wire:model="keyword" placeholder="Cari lowongan kerja..."
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
                                Search Jobs
                            </button>
                        </div>

                        @if(isset($section['items']['kategori']) && is_array($section['items']['kategori']))
                            <div class="mt-6 flex flex-wrap gap-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Popular searches:</span>
                                @foreach ($section['items']['kategori'] as $tag)
                                    <button type="button" wire:click="searchCategory('{{ $tag['category'] ?? $tag }}')"
                                        class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 text-gray-700 dark:text-gray-300 rounded-full text-sm transition-colors">
                                        {{ $tag['category'] ?? $tag }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </form>
                @endif

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md text-center border border-gray-100 dark:border-slate-700">
                        <div class="text-3xl font-bold text-teal-600 dark:text-teal-400 mb-1">150+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Active Jobs</div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md text-center border border-gray-100 dark:border-slate-700">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">50+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Companies</div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md text-center border border-gray-100 dark:border-slate-700">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">8+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Job Categories</div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md text-center border border-gray-100 dark:border-slate-700">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">Daily</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">New Postings</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>