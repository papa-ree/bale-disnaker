<header x-data="umpakNav()" wire:cloak @click.outside="closeDropdown(); mobileOpen = false"
    class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-slate-800">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            {{-- Logo and Brand --}}
            <a href="{{ route('index') }}" class="flex items-center gap-3">
                <img src="{{ cdn_asset('shared/logo-png.png') }}" class="md:h-12 md:w-12 h-8 w-8 object-contain"
                    loading="lazy" alt="logo ponorogo"
                    referrerpolicy="{{ app()->isLocal() ? 'no-referrer' : 'strict-origin-when-cross-origin' }}">
                <div class="flex flex-col">
                    <span class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Dinas Tenaga Kerja</span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Kabupaten Ponorogo</span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-8">
                @foreach ($umpakNav as $i => $item)
                    @php
                        $isInternal = str_starts_with($item->resolvedUrl, '/') || str_contains($item->resolvedUrl, config('app.url'));
                        $isAnchor = str_contains($item->resolvedUrl, '#');
                        $useNavigate = $isInternal && !$isAnchor;
                    @endphp

                    @if ($item->hasChildren())
                        <div class="relative cursor-pointer"
                            @click="isDropdownOpen({{ $i }}) ? closeDropdown() : openDropdown({{ $i }})"
                            @click.outside="isDropdownOpen({{ $i }}) ? closeDropdown() : null">
                            <button type="button" @class([
                                'flex items-center cursor-pointer gap-1 text-base font-medium transition-colors hover:text-teal-600 dark:hover:text-teal-400 focus:outline-none',
                                'text-teal-600 dark:text-teal-400' => str_starts_with(request()->url(), $item->resolvedUrl),
                                'text-gray-700 dark:text-gray-300' => !str_starts_with(request()->url(), $item->resolvedUrl),
                            ])>
                                <span>{{ $item->name }}</span>
                                <x-umpak::icon name="chevron-down" class="w-4 h-4 duration-300"
                                    ::class="isDropdownOpen({{ $i }}) ? '-rotate-180' : ''" />
                            </button>

                            <div x-show="isDropdownOpen({{ $i }})" x-cloak x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute left-1/2 -translate-x-1/2 mt-3 w-56 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-100 dark:border-slate-700/50 py-1.5 z-50">
                                <div
                                    class="py-1 px-1 space-y-0.5 max-h-[calc(100vh-140px)] overflow-y-auto scrollbar-thin scrollbar-thumb-teal-600 scrollbar-track-gray-100/50">
                                    @foreach ($item->children as $child)
                                        @php
                                            $childInternal = str_starts_with($child->resolvedUrl, '/') || str_contains($child->resolvedUrl, config('app.url'));
                                            $childAnchor = str_contains($child->resolvedUrl, '#');
                                            $childNavigate = $childInternal && !$childAnchor;
                                        @endphp
                                        <a href="{{ $child->resolvedUrl }}" @if($childNavigate) wire:navigate.hover @endif
                                            class="flex items-center p-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-lg transition-colors">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $item->resolvedUrl }}" @if($useNavigate) wire:navigate.hover @endif @class([
                            'text-base font-medium transition-colors duration-200 hover:text-teal-600 dark:hover:text-teal-400',
                            'text-teal-600 dark:text-teal-400' => request()->url() == $item->resolvedUrl || (request()->is('/') && $item->slug == 'beranda'),
                            'text-gray-700 dark:text-gray-300' => request()->url() != $item->resolvedUrl && !(request()->is('/') && $item->slug == 'beranda'),
                        ])>
                            {{ $item->name }}
                        </a>
                    @endif
                @endforeach

                {{-- Dark Mode Toggle --}}
                <button type="button" @click="setTheme('dark')" x-show="!isDark"
                    class="cursor-pointer w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-800/50 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-slate-700/50 transition-all duration-300">
                    <span class="group inline-flex shrink-0 justify-center items-center size-9">
                        <x-umpak::icon name="moon" class="shrink-0 size-4" />
                    </span>
                </button>
                <button type="button" @click="setTheme('light')" x-show="isDark" x-cloak
                    class="cursor-pointer w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-800/50 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-slate-700/50 transition-all duration-300">
                    <span class="group inline-flex shrink-0 justify-center items-center size-9">
                        <x-umpak::icon name="sun" class="shrink-0 size-4" />
                    </span>
                </button>

                <a href="{{ route('bale.jobs') }}" wire:navigate.hover
                    class="px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-colors">
                    Cari Lowongan Kerja
                </a>
            </div>

            {{-- Mobile Actions --}}
            <div class="flex items-center gap-2 lg:hidden">
                <button @click="toggleTheme()"
                    class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-800/50 flex items-center justify-center text-gray-700 dark:text-gray-300"
                    aria-label="Toggle dark mode">
                    <x-umpak::icon name="moon" class="w-4 h-4" x-show="!isDark" />
                    <x-umpak::icon name="sun" class="w-4 h-4" x-show="isDark" x-cloak />
                </button>
                <button @click="toggleMobile()" aria-label="Toggle menu"
                    class="p-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                    <x-umpak::icon name="menu" class="w-6 h-6" x-show="!mobileOpen" />
                    <x-umpak::icon name="x" class="w-6 h-6" x-show="mobileOpen" x-cloak />
                </button>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="lg:hidden mt-4 pt-4 border-t border-gray-200 dark:border-slate-800">
            <div class="flex flex-col gap-1">
                @foreach ($umpakNav as $i => $item)
                    @php
                        $isInternal = str_starts_with($item->resolvedUrl, '/') || str_contains($item->resolvedUrl, config('app.url'));
                        $isAnchor = str_contains($item->resolvedUrl, '#');
                        $useNavigate = $isInternal && !$isAnchor;
                    @endphp

                    @if ($item->hasChildren())
                        <div class="space-y-1 overflow-hidden transition-all duration-300">
                            <button @click="isDropdownOpen({{ $i }}) ? closeDropdown() : openDropdown({{ $i }})"
                                class="w-full flex items-center justify-between px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-all focus:outline-none">
                                <span>{{ $item->name }}</span>
                                <x-umpak::icon name="chevron-down" class="w-4 h-4 transition-transform duration-300"
                                    ::class="isDropdownOpen({{ $i }}) ? 'rotate-180 text-teal-600 dark:text-teal-400' : ''" />
                            </button>

                            <div x-show="isDropdownOpen({{ $i }})" x-cloak x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="flex flex-col gap-1 mt-1 ps-4 border-l-2 border-gray-150 dark:border-slate-800 ms-3">
                                @foreach ($item->children as $child)
                                    @php
                                        $childInternal = str_starts_with($child->resolvedUrl, '/') || str_contains($child->resolvedUrl, config('app.url'));
                                        $childAnchor = str_contains($child->resolvedUrl, '#');
                                        $childNavigate = $childInternal && !$childAnchor;
                                    @endphp
                                    <a href="{{ $child->resolvedUrl }}" @if($childNavigate) wire:navigate.hover @endif
                                        @click="onLinkClick()"
                                        class="px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-lg transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $item->resolvedUrl }}" @if($useNavigate) wire:navigate.hover @endif @click="onLinkClick()"
                            @class([
                                'px-3 py-2 text-base font-medium rounded-lg transition-colors hover:text-teal-600 dark:hover:text-teal-400',
                                'text-teal-600 dark:text-teal-400 bg-teal-50/50 dark:bg-teal-900/10' => request()->url() == $item->resolvedUrl || (request()->is('/') && $item->slug == 'beranda'),
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800/50' => request()->url() != $item->resolvedUrl && !(request()->is('/') && $item->slug == 'beranda'),
                            ])>
                            {{ $item->name }}
                        </a>
                    @endif
                @endforeach

                <div class="mt-4 px-3 flex flex-col gap-4">
                    <a href="{{ route('bale.jobs') }}" @click="onLinkClick()" wire:navigate.hover
                        class="px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-colors text-center shadow-lg shadow-teal-600/20">
                        Cari Lowongan Kerja
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>