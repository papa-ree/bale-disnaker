<header x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-slate-800">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            {{-- Logo and Brand --}}
            <a href="{{ route('index') }}" class="flex items-center gap-3">
                <img src="{{ cdn_asset('shared/logo-png.png') }}" class="h-12 w-12 object-contain" loading="lazy"
                    alt="logo ponorogo"
                    referrerpolicy="{{ app()->isLocal() ? 'no-referrer' : 'strict-origin-when-cross-origin' }}">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">Disnaker Ponorogo</span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Dinas Tenaga Kerja</span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('index') }}" wire:navigate.hover
                    class="text-base font-medium transition-colors hover:text-teal-600 dark:hover:text-teal-400 {{ request()->routeIs('index') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-700 dark:text-gray-300' }}">
                    Home
                </a>

                @foreach ($this->availableNavs as $nav)
                    @if ($nav->children->isNotEmpty())
                        <div class="hs-dropdown [--strategy:static] lg:[--strategy:fixed] [--adaptive:none] lg:[--adaptive:adaptive] [--is-collapse:true] lg:[--is-collapse:false] ">
                            <button id="bale-disnaker-{{ $nav->slug }}" type="button"
                                class="hs-dropdown-toggle flex items-center gap-1 text-base font-medium transition-colors hover:text-teal-600 dark:hover:text-teal-400 text-gray-700 dark:text-gray-300 focus:outline-none">
                                {{ $nav->name }}
                                <svg class="hs-dropdown-open:-rotate-180 lg:hs-dropdown-open:rotate-0 duration-300 shrink-0 size-4"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] lg:duration-150 hs-dropdown-open:opacity-100 opacity-0 relative w-full lg:w-56 hidden z-10 top-full ps-7 lg:ps-0 lg:bg-white dark:lg:bg-slate-800 lg:rounded-lg lg:shadow-lg before:absolute before:-top-4 before:start-0 before:w-full before:h-5"
                                role="menu" aria-orientation="vertical" aria-labelledby="bale-disnaker-{{ $nav->slug }}">
                                <div class="py-1 lg:px-1 space-y-0.5 max-h-[calc(100vh-140px)] overflow-y-auto scrollbar-thin scrollbar-thumb-teal-600 scrollbar-track-gray-100/50">
                                    @foreach ($nav->children as $navItem)
                                        <a class="flex items-center p-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-lg transition-colors"
                                            @if ($navItem->url_mode) href="{{ $navItem->url }}" target="{{ $navItem->target ?? '_self' }}"
                                            {{ Illuminate\Support\Str::startsWith($navItem->url, '/') ? 'wire:navigate.hover' : '' }} @else
                                            href="{{ route('bale.view-page', $navItem->page_slug ?? '404') }}" wire:navigate.hover @endif>
                                            {{ $navItem->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a @if ($nav->url_mode) href="{{ $nav->url }}" target="{{ $nav->target ?? '_self' }}"
                            {{ Illuminate\Support\Str::startsWith($nav->url, '/') ? 'wire:navigate.hover' : '' }} @else
                            href="{{ route('bale.view-page', $nav->page_slug ?? '404') }}" wire:navigate.hover @endif
                            class="text-base font-medium transition-colors hover:text-teal-600 dark:hover:text-teal-400 text-gray-700 dark:text-gray-300">
                            {{ $nav->name }}
                        </a>
                    @endif
                @endforeach

                <x-bale-disnaker::dark-mode-toggle />

                <a href="{{ route('bale.jobs') }}" wire:navigate.hover
                    class="px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-colors">
                    Cari Lowongan Kerja
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition-colors"
                aria-label="Toggle menu">
                <x-lucide-menu x-show="!mobileMenuOpen" class="w-6 h-6" />
                <x-lucide-x x-show="mobileMenuOpen" class="w-6 h-6" />
            </button>
        </div>

        {{-- Mobile Navigation --}}
        <div x-show="mobileMenuOpen" x-transition
            class="lg:hidden mt-4 pt-4 border-t border-gray-200 dark:border-slate-800">
            <div class="flex flex-col gap-1">
                <a href="{{ route('index') }}" @click="mobileMenuOpen = false"
                    class="px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-colors">
                    Home
                </a>

                @foreach ($this->availableNavs as $nav)
                    @if ($nav->children->isNotEmpty())
                        <div class="hs-accordion-group">
                            <div class="hs-accordion" id="mobile-nav-{{ $nav->slug }}">
                                <button
                                    class="hs-accordion-toggle flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-colors focus:outline-none">
                                    {{ $nav->name }}
                                    <svg class="hs-accordion-active:rotate-180 duration-300 size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>
                                <div id="mobile-nav-{{ $nav->slug }}-child"
                                    class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                                    <div class="flex flex-col gap-1 mt-1 ps-4 border-l-2 border-gray-100 dark:border-slate-800 ms-3">
                                        @foreach ($nav->children as $navItem)
                                            <a @if ($navItem->url_mode) href="{{ $navItem->url }}" target="{{ $navItem->target ?? '_self' }}"
                                                {{ Illuminate\Support\Str::startsWith($navItem->url, '/') ? 'wire:navigate.hover' : '' }} @else
                                                href="{{ route('bale.view-page', $navItem->page_slug ?? '404') }}" wire:navigate.hover @endif
                                                @click="mobileMenuOpen = false"
                                                class="px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-colors">
                                                {{ $navItem->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a @if ($nav->url_mode) href="{{ $nav->url }}" target="{{ $nav->target ?? '_self' }}"
                            {{ Illuminate\Support\Str::startsWith($nav->url, '/') ? 'wire:navigate.hover' : '' }} @else
                            href="{{ route('bale.view-page', $nav->page_slug ?? '404') }}" wire:navigate.hover @endif
                            @click="mobileMenuOpen = false"
                            class="px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-colors">
                            {{ $nav->name }}
                        </a>
                    @endif
                @endforeach

                <div class="mt-4 px-3 flex flex-col gap-4">
                    <a href="{{ route('bale.jobs') }}" @click="mobileMenuOpen = false" wire:navigate.hover
                        class="px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-colors text-center shadow-lg shadow-teal-600/20">
                        Cari Lowongan Kerja
                    </a>
                    <div class="flex justify-center py-2 border-t border-gray-100 dark:border-slate-800">
                        <x-bale-disnaker::dark-mode-toggle />
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>