@props([
    'title',
    'breadcrumbs' => [],
    'subtitle' => null,
    'meta' => null,
    'background' => null,
])

<section class="relative pt-32 pb-20 bg-primary overflow-hidden">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0 z-0">
        @php
            $bgImage = $background ?? '';
            $altText = $title ?? 'Tenaga kerja profesional';
            if ($bgImage && !\Illuminate\Support\Str::startsWith($bgImage, 'http')) {
                if (!\Illuminate\Support\Str::startsWith($bgImage, ['landing-page/', 'thumbnails/'])) {
                    $bgImage = 'landing-page/' . $bgImage;
                }
            }
        @endphp
        @if ($bgImage)
            <x-umpak::cdn-img :path="$bgImage" :alt="$altText" class="w-full h-full object-cover" />
        @endif
        <div class="absolute inset-0 bg-linear-to-r from-gray-900/95 via-gray-900/85 to-teal-900/75"></div>
    </div>

    {{-- Peacock Accent Elements --}}
    <div class="absolute top-20 right-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        {{-- Breadcrumb --}}
        @if(count($breadcrumbs) > 0)
            <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('index') }}" wire:navigate.hover
                            class="inline-flex items-center text-sm font-medium text-white/80 hover:text-white transition-colors">
                            <x-umpak::icon name="home" class="w-4 h-4 mr-2" />
                            Beranda
                        </a>
                    </li>
                    @foreach($breadcrumbs as $breadcrumb)
                        <li>
                            <div class="flex items-center">
                                <x-umpak::icon name="chevron-right" class="w-5 h-5 text-white/60" />
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" wire:navigate.hover class="ml-1 text-sm font-medium text-white/80 hover:text-white md:ml-2">
                                        {{ $breadcrumb['label'] }}
                                    </a>
                                @else
                                    <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ $breadcrumb['label'] }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ $title }}
        </h1>

        {{-- Subtitle --}}
        @if($subtitle)
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                {{ $subtitle }}
            </p>
        @endif

        {{-- Meta Information --}}
        @if($meta)
            <div class="mt-4 flex items-center justify-center gap-4 text-sm text-white/70">
                <span class="flex items-center gap-1">
                    <x-umpak::icon name="calendar" class="w-4 h-4" />
                    {{ $meta }}
                </span>
            </div>
        @endif
    </div>
</section>
