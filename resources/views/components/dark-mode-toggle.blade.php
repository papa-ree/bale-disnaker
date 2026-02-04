<div>
    {{-- Light Mode Button (shows moon icon, switches to dark) --}}
    <button type="button"
        class="hs-dark-mode block hs-dark-mode-active:hidden p-2.5 cursor-pointer rounded-lg text-gray-500 hover:bg-gray-100 hover:text-teal-600 dark:text-gray-400 dark:hover:bg-slate-800 dark:hover:text-teal-400 transition-all duration-300 focus:outline-none"
        data-hs-theme-click-value="dark" aria-label="Switch to dark mode">
        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
        </svg>
    </button>

    {{-- Dark Mode Button (shows sun icon, switches to light) --}}
    <button type="button"
        class="hs-dark-mode hidden hs-dark-mode-active:block p-2.5 cursor-pointer rounded-lg text-gray-500 hover:bg-gray-100 hover:text-secondary dark:text-gray-400 dark:hover:bg-slate-800 dark:hover:text-secondary transition-all duration-300 focus:outline-none"
        data-hs-theme-click-value="light" aria-label="Switch to light mode">
        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2"></path>
            <path d="M12 20v2"></path>
            <path d="m4.93 4.93 1.41 1.41"></path>
            <path d="m17.66 17.66 1.41 1.41"></path>
            <path d="M2 12h2"></path>
            <path d="M20 12h2"></path>
            <path d="m6.34 17.66-1.41 1.41"></path>
            <path d="m19.07 4.93-1.41 1.41"></path>
        </svg>
    </button>
</div>