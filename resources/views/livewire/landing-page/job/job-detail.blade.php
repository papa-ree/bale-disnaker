<div class="min-h-screen bg-gray-50 dark:bg-slate-900 pt-32 pb-20">
    <div class="container mx-auto px-4">
        {{-- Breadcrumb --}}
        <div class="max-w-6xl mx-auto mb-8">
            <a href="{{ route('bale.jobs') }}" wire:navigate.hover
                class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-teal-600 transition-colors">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Back to Jobs
            </a>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Header Card --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $job['title'] }}</h1>
                            <div class="text-xl text-teal-600 dark:text-teal-400 font-medium mb-4">{{ $job['company'] }}
                            </div>

                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1.5">
                                    <x-lucide-map-pin class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                    {{ $job['location'] }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <x-lucide-briefcase class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                    {{ $job['type'] }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <x-lucide-clock class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                    {{ \Carbon\Carbon::parse($job['updated_at'])->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons for Mobile --}}
                        <div class="flex md:hidden flex-col gap-3">
                            <a href="#apply-section"
                                class="w-full py-3 bg-teal-600 text-white text-center rounded-xl font-semibold">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Job Description --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Job Description</h2>
                    <ul class="space-y-3">
                        @foreach($job['description'] as $desc)
                            <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400 leading-relaxed">
                                <x-lucide-check-circle-2 class="w-5 h-5 text-teal-500 mt-0.5 shrink-0" />
                                <span>{{ $desc }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Requirements --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Requirements</h2>
                    <ul class="space-y-3">
                        @foreach($job['requirements'] as $req)
                            <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400 leading-relaxed">
                                <span class="w-1.5 h-1.5 bg-teal-500 dark:bg-teal-400 rounded-full mt-2.5 shrink-0"></span>
                                <span>{{ $req }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Documents --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Required Documents</h2>
                    <ul class="space-y-3">
                        @foreach($job['documents'] as $doc)
                            <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400 leading-relaxed">
                                <x-lucide-file-text class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 shrink-0" />
                                <span>{{ $doc }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Job Overview --}}
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 sticky top-32">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-6">Job Overview</h3>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center shrink-0">
                                <x-lucide-coins class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Salary</div>
                                <div class="font-semibold text-gray-900 dark:text-white">Rp. {{ $job['salary'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
                                <x-lucide-tag class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Category</div>
                                <div class="font-semibold text-gray-900 dark:text-white">{{ $job['category'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center shrink-0">
                                <x-lucide-calendar class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-500 mb-1">Posted</div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($job['posted_at'])->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-slate-700 my-6 pt-6">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4">How to Apply</h4>
                        <div
                            class="space-y-3 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl">
                            @foreach($job['apply'] as $info)
                                <div class="capitalize">{{ $info }}</div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ $job['url'] }}" target="_blank"
                        class="w-full block py-3 bg-teal-600 hover:bg-teal-700 text-white text-center rounded-xl font-semibold transition-colors shadow-lg shadow-teal-600/20">
                        Apply Now
                    </a>

                    {{-- Company Info --}}
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">About {{ $job['company'] }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                            @foreach($job['company_description'] as $desc)
                                {{ $desc }}
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>