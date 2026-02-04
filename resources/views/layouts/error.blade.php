<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Error') - Dinas Tenaga Kerja Kabupaten Ponorogo</title>
    <link rel="icon" type="image/x-icon" href="{{ cdn_asset('shared/favicon.ico') }}" referrerpolicy="no-referrer">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <x-emperan::balystics-tag />
</head>

<body
    class="min-h-screen bg-gray-100 dark:bg-slate-900 scrollbar-thin scrollbar-thumb-primary scrollbar-track-gray-100/50 scrollbar-thumb-rounded-full scrollbar-track-rounded-full overscroll-none">

    <livewire:bale-disnaker.shared-components.topbar />

    <main class="min-h-[calc(100vh-80px)] flex items-center justify-center pt-20">
        @yield('content')
    </main>

    <livewire:bale-disnaker.landing-page.footer.index />
    @livewireScripts

</body>

</html>