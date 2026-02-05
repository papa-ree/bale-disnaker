<div class="min-h-screen bg-gray-50 dark:bg-slate-900">

    {{-- header --}}
    <x-bale-disnaker::header-page 
        :title="$section['content']['meta']['title'] ?? 'News & Announcements'"
        :subtitle="$section['content']['meta']['subtitle'] ?? 'Stay informed with the latest updates from Disnaker Ponorogo'"
        :background="$section['content']['meta']['background'] ?? null"
        :breadcrumbs="[['label' => $section['content']['meta']['title'] ?? 'News & Announcements']]"
    />

    {{-- Search Form --}}
    <section class="top-14 z-20 bg-gray-50/95 dark:bg-slate-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-slate-800 py-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                        {{-- Search Input --}}
                        <div class="lg:col-span-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search News</label>
                            <div class="relative">
                                <input type="text" wire:model="search"
                                    placeholder="Search news by title or content..."
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Date Picker --}}
                        <div class="lg:col-span-5" wire:ignore x-data="{
                            picker: null,
                            init() {
                                this.picker = flatpickr(this.$refs.picker, {
                                    mode: 'range',
                                    dateFormat: 'Y-m-d',
                                    defaultDate: @js($date),
                                    onChange: (selectedDates, dateStr) => {
                                        // Update the hidden input which is wire:modeled
                                        this.$refs.dateInput.value = dateStr;
                                        this.$refs.dateInput.dispatchEvent(new Event('input'));
                                    }
                                });

                                this.$watch('$wire.date', (value) => {
                                    if (!value && this.picker) {
                                        this.picker.clear(false);
                                    }
                                });
                            }
                        }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Date</label>
                            <div class="relative">
                                <input type="hidden" x-ref="dateInput" wire:model="date">
                                <input x-ref="picker" type="text" placeholder="Date range..." readonly
                                    class="w-full pl-10 pr-10 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white cursor-pointer">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <button type="button" @click="if(picker) { picker.clear(); } $wire.set('date', '');" x-show="$wire.date"
                                    class="absolute right-3 top-3 cursor-pointer text-gray-400 hover:text-red-500 transition-colors"
                                    title="Clear date">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="lg:col-span-2 flex items-end gap-2">
                            <button wire:click="$refresh" type="button"
                                class="flex-1 px-4 py-2.5 bg-teal-600 text-white cursor-pointer font-medium rounded-xl hover:bg-teal-700 transition-colors shadow-lg shadow-teal-600/20">
                                Refresh
                            </button>
                            @if($search || $date)
                                <button wire:click="clearSearch(); date = ''" type="button"
                                    class="px-4 py-2.5 bg-gray-100 dark:bg-slate-700 cursor-pointer text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors"
                                    title="Reset Filter text-primary">
                                    <x-lucide-filter-x class="w-5 h-5" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Posts Grid --}}
    <section class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Skeleton Loaders --}}
            <div wire:loading.grid wire:target="search, date, $refresh, clearSearch" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 max-w-7xl mx-auto mb-16">
                @for ($i = 0; $i < 6; $i++)
                    <div class="bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl overflow-hidden shadow-sm md:shadow-md border border-gray-100 dark:border-slate-700 animate-pulse flex md:block gap-4 p-3 md:p-0">
                        <div class="h-24 w-24 md:h-56 md:w-full bg-gray-200 dark:bg-slate-700 shrink-0 rounded-lg md:rounded-none"></div>
                        <div class="p-0 md:p-6 flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-2 md:mb-3">
                                <div class="w-4 h-4 bg-gray-200 dark:bg-slate-700 rounded hidden md:block"></div>
                                <div class="w-20 md:w-24 h-3 md:h-4 bg-gray-200 dark:bg-slate-700 rounded"></div>
                            </div>
                            <div class="h-4 md:h-6 bg-gray-200 dark:bg-slate-700 rounded w-full md:w-3/4 mb-2 md:mb-3"></div>
                            <div class="h-4 md:h-6 bg-gray-200 dark:bg-slate-700 rounded w-2/3 md:w-1/2 mb-4"></div>
                            <div class="space-y-2 mb-4 hidden md:block">
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded"></div>
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded"></div>
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-2/3"></div>
                            </div>
                            <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-32 hidden md:block"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <div wire:loading.remove wire:target="search, date, $refresh, clearSearch" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 max-w-7xl mx-auto mb-16">
                @forelse ($this->posts as $post)
                    <article wire:key='{{ $post->id }}'
                        class="group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl overflow-hidden shadow-sm md:shadow-md hover:shadow-md md:hover:shadow-2xl hover:border-teal-600 transition-all duration-300 border border-gray-100 dark:border-slate-700">
                        <a href="{{ route('bale.view-post', $post->slug) }}" wire:navigate.hover class="flex md:block gap-4 p-3 md:p-0">
                            {{-- Image --}}
                            <div class="relative h-24 w-24 md:h-56 md:w-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                                @if ($post->thumbnail)
                                    <img src="{{ cdn_asset('thumbnails/' . $post->thumbnail) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy" />
                                @else
                                    <div class="w-full h-full group-hover:scale-150 transition-transform duration-500 bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($post?->category?->name)
                                    <div class="absolute top-4 left-4 hidden md:block">
                                        <span class="px-3 py-1 bg-teal-600 text-white text-xs font-semibold rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-0 md:p-6 flex-1 flex flex-col justify-center">
                                <div class="flex items-center gap-2 text-[10px] md:text-sm font-bold md:font-normal text-teal-600/60 md:text-gray-500 dark:text-teal-400 md:dark:text-gray-400 mb-1 md:mb-3 uppercase tracking-wider md:normal-case md:tracking-normal">
                                    <x-lucide-calendar class="w-4 h-4 hidden md:block" />
                                    <span>{{ $post->created_at }}</span>
                                </div>

                                <h3 class="text-sm md:text-xl font-bold text-gray-900 dark:text-white mb-1 md:mb-3 group-hover:text-teal-600 transition-colors leading-tight md:leading-snug line-clamp-2">
                                    {{ $post->title }}
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 hidden md:block">
                                    {{ $post->excerpt(120) }}
                                </p>

                                <span class="hidden md:inline-flex items-center gap-2 text-teal-600 font-semibold hover:text-teal-700 transition-colors group/link">
                                    Read Full Article
                                    <x-lucide-arrow-right class="w-[18px] h-[18px] group-hover/link:translate-x-1 transition-transform" />
                                </span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <x-lucide-search class="text-gray-400 w-10 h-10" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No articles found</h3>
                        <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter to find what you're looking for.</p>
                    </div>
                @endforelse
            </div>

            {{-- Load More Button --}}
            @if($this->hasMore)
                <div class="text-center">
                    <button wire:click="loadMore" wire:loading.attr="disabled"
                        class="px-10 py-4 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition-all shadow-lg hover:shadow-xl inline-flex items-center gap-2 group">
                        <span wire:loading.remove>Load More News</span>
                        <span wire:loading>Loading...</span>
                        <x-lucide-chevron-down wire:loading.remove class="w-5 h-5 group-hover:translate-y-1 transition-transform" />
                        <svg wire:loading class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </section>
</div>
