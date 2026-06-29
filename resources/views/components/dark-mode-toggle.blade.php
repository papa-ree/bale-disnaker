<div>
    {{-- Light Mode Button (shows moon icon, switches to dark) --}}
    <button type="button"
        class="hs-dark-mode block hs-dark-mode-active:hidden p-2.5 cursor-pointer rounded-lg text-gray-500 hover:bg-gray-100 hover:text-teal-600 dark:text-gray-400 dark:hover:bg-slate-800 dark:hover:text-teal-400 transition-all duration-300 focus:outline-none"
        data-hs-theme-click-value="dark" aria-label="Switch to dark mode">
        <x-umpak::icon name="moon" class="shrink-0 size-5" />
    </button>

    {{-- Dark Mode Button (shows sun icon, switches to light) --}}
    <button type="button"
        class="hs-dark-mode hidden hs-dark-mode-active:block p-2.5 cursor-pointer rounded-lg text-gray-500 hover:bg-gray-100 hover:text-secondary dark:text-gray-400 dark:hover:bg-slate-800 dark:hover:text-secondary transition-all duration-300 focus:outline-none"
        data-hs-theme-click-value="light" aria-label="Switch to light mode">
        <x-umpak::icon name="sun" class="shrink-0 size-5" />
    </button>
</div>
