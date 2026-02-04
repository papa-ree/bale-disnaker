<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    <div class="pt-32 pb-20 container mx-auto px-4">
        {{-- Page Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $meta['title'] ?? 'Job Vacancies' }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                {{ $meta['subtitle'] ?? 'Discover exciting career opportunities in Ponorogo' }}
            </p>
        </div>

        {{-- Search and Filters --}}
        <div class="max-w-5xl mx-auto mb-12">
            <form wire:submit.prevent="$refresh"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-slate-700">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    {{-- Search Input --}}
                    <div class="md:col-span-5 relative">
                        <input type="text" placeholder="Job title or company..." wire:model="searchQuery"
                            class="w-full pl-12 h-14 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white">
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    {{-- Job Type Filter --}}
                    <div class="md:col-span-3">
                        <select wire:model="selectedType"
                            class="w-full pl-4 h-14 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white">
                            @foreach ($jobTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category Filter --}}
                    <div class="md:col-span-3">
                        <select wire:model="selectedCategory"
                            class="w-full pl-4 h-14 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all dark:text-white">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search Button --}}
                    <div class="md:col-span-1">
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full h-14 bg-teal-600 hover:bg-teal-700 text-white rounded-xl transition-all shadow-lg shadow-teal-600/20 flex items-center justify-center group">
                            <x-lucide-search wire:loading.remove
                                wire:target="searchQuery, selectedType, selectedCategory, $refresh" class="w-5 h-5" />
                            <svg wire:loading wire:target="searchQuery, selectedType, selectedCategory, $refresh"
                                class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Active Filters --}}
                @if ($searchQuery || $selectedType !== 'All' || $selectedCategory !== 'All')
                    <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                        @if ($searchQuery)
                            <span
                                class="px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 rounded-full text-sm">
                                Search: "{{ $searchQuery }}"
                            </span>
                        @endif
                        @if ($selectedType !== 'All')
                            <span
                                class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-sm">
                                Type: {{ $selectedType }}
                            </span>
                        @endif
                        @if ($selectedCategory !== 'All')
                            <span
                                class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-sm">
                                Category: {{ $selectedCategory }}
                            </span>
                        @endif
                        <button type="button" wire:click="clearFilters"
                            class="ml-auto text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-1 transition-colors">
                            <x-lucide-x class="w-4 h-4" />
                            Clear all
                        </button>
                    </div>
                @endif
            </form>
        </div>

        {{-- Results Count --}}
        <div class="max-w-5xl mx-auto mb-8">
            <p class="text-gray-600 dark:text-gray-400">
                Found <span class="font-semibold text-gray-900 dark:text-white">{{ count($jobs) }}</span>
                {{ count($jobs) === 1 ? 'job' : 'jobs' }}
            </p>
        </div>

        {{-- Skeleton Loaders --}}
        <div wire:loading.block wire:target="searchQuery, selectedType, selectedCategory, $refresh, clearFilters"
            class="max-w-5xl mx-auto space-y-6 mb-8">
            @for ($i = 0; $i < 3; $i++)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 md:p-8 shadow-md border border-gray-100 dark:border-slate-700 animate-pulse">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="h-8 bg-gray-200 dark:bg-slate-700 rounded w-1/3 mb-4"></div>
                            <div class="h-6 bg-gray-200 dark:bg-slate-700 rounded w-1/4 mb-6"></div>
                            <div class="flex flex-wrap gap-4 mb-6 text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div class="w-[18px] h-[18px] bg-gray-200 dark:bg-slate-700 rounded-full"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-20"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-[18px] h-[18px] bg-gray-200 dark:bg-slate-700 rounded-full"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-20"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-[18px] h-[18px] bg-gray-200 dark:bg-slate-700 rounded-full"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-20"></div>
                                </div>
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-full"></div>
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-full"></div>
                                <div class="h-4 bg-gray-200 dark:bg-slate-700 rounded w-2/3"></div>
                            </div>
                            <div class="h-6 bg-gray-200 dark:bg-slate-700 rounded-full w-24"></div>
                        </div>
                        <div class="w-full md:w-32 h-12 bg-gray-200 dark:bg-slate-700 rounded-xl"></div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- Jobs List --}}
        <div wire:loading.remove wire:target="searchQuery, selectedType, selectedCategory, $refresh, clearFilters">
            @if (count($jobs) > 0)
                <div class="max-w-5xl mx-auto space-y-6">
                    @foreach ($jobs as $job)
                        <article
                            class="bg-white dark:bg-slate-800 rounded-2xl p-6 md:p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-700">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div class="flex-1">
                                    {{-- Job Header --}}
                                    <div class="mb-4">
                                        <h3
                                            class="text-2xl font-bold text-gray-900 dark:text-white mb-2 hover:text-teal-700 dark:hover:text-teal-400 transition-colors">
                                            {{ $job['title'] }}
                                        </h3>
                                        <p class="text-lg text-gray-700 dark:text-gray-300 font-medium">{{ $job['company'] }}
                                        </p>
                                    </div>

                                    {{-- Job Details --}}
                                    <div class="flex flex-wrap gap-4 mb-4 text-gray-600 dark:text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <x-lucide-map-pin class="w-[18px] h-[18px] text-teal-600 dark:text-teal-400" />
                                            <span>{{ $job['location'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-lucide-briefcase class="w-[18px] h-[18px] text-blue-600 dark:text-blue-400" />
                                            <span>{{ $job['type'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-lucide-dollar-sign
                                                class="w-[18px] h-[18px] text-green-600 dark:text-green-400" />
                                            <span>{{ $job['salary'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-lucide-clock class="w-[18px] h-[18px] text-purple-600 dark:text-purple-400" />
                                            <span>{{ \Carbon\Carbon::parse($job['postedDate'])->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    {{-- Job Description --}}
                                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                                        {{ $job['description'] }}
                                    </p>

                                    {{-- Category Badge --}}
                                    <div class="flex gap-2">
                                        <span
                                            class="px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 rounded-full text-sm font-medium">
                                            {{ $job['category'] }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Apply Button --}}
                                <div class="md:ml-6">
                                    <a href="{{ route('bale.view-job', $job['id']) }}"
                                        class="w-full md:w-auto px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors inline-block text-center"
                                        wire:navigate>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="max-w-5xl mx-auto text-center py-16">
                    <div
                        class="w-24 h-24 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-100 dark:border-slate-700">
                        <x-lucide-search class="text-gray-400 w-10 h-10" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No jobs found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Try adjusting your search or filters to find what you're looking for.
                    </p>
                    <button wire:click="clearFilters"
                        class="inline-flex px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-colors">
                        Clear Filters
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
</div>