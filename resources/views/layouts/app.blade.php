<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dinas Tenaga Kerja Kabupaten Ponorogo' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ cdn_asset('shared/favicon.ico') }}"
        referrerpolicy="{{ app()->isLocal() ? 'no-referrer' : 'strict-origin-when-cross-origin' }}">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <x-emperan::balystics-tag />

    <script>
        const html = document.querySelector( 'html' );
        const isLightOrAuto = localStorage.getItem( 'hs_theme' ) === 'light' || ( localStorage.getItem( 'hs_theme' ) === 'auto' && !window.matchMedia( '(prefers-color-scheme: dark)' ).matches );
        const isDarkOrAuto = localStorage.getItem( 'hs_theme' ) === 'dark' || ( localStorage.getItem( 'hs_theme' ) === 'auto' && window.matchMedia( '(prefers-color-scheme: dark)' ).matches );

        if ( isLightOrAuto && html.classList.contains( 'dark' ) ) html.classList.remove( 'dark' );
        else if ( isDarkOrAuto && !html.classList.contains( 'dark' ) ) html.classList.add( 'dark' );
    </script>

</head>

<body
    class="min-h-screen bg-gray-100 dark:bg-slate-900 scrollbar-thin scrollbar-thumb-teal-600 scrollbar-track-gray-100/50 scrollbar-thumb-rounded-full scrollbar-track-rounded-full overscroll-none">

    <livewire:bale-disnaker.shared-components.topbar />

    <main class="pt-20"> {{-- Added padding-top to account for fixed header --}}
        {{ $slot }}
    </main>

    <livewire:bale-disnaker.landing-page.footer.index />

    @livewireScripts

</body>

</html>