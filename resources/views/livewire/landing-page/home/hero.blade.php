<section class="relative min-h-screen flex items-center overflow-hidden">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0 z-0">
        @php
            $bgImage = $section['content']['meta']['background'] ?? '';
            $altText = $section['content']['meta']['title'] ?? 'Professional workforce';
        @endphp
        <img src="{{ Str::startsWith($bgImage, 'http') ? $bgImage : cdn_asset('landing-page/' . $bgImage) }}"
            alt="{{ $altText }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-linear-to-r from-gray-900/95 via-gray-900/85 to-teal-900/75"></div>
    </div>

    {{-- Peacock Accent Elements --}}
    <div class="absolute top-20 right-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>

    {{-- Content --}}
    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl">
            @if(!empty($section['content']['meta']['organization'] ?? null))
                <div class="inline-block mb-6">
                    <span
                        class="px-4 py-2 bg-teal-600/20 border border-teal-400/30 text-teal-300 rounded-full text-sm font-medium backdrop-blur-sm">
                        {{ $section['content']['meta']['organization'] }}
                    </span>
                </div>
            @endif

            @if(!empty($section['content']['meta']['title'] ?? null))
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    {!! nl2br(e($section['content']['meta']['title'])) !!}
                </h1>
            @endif

            @if(!empty($section['content']['meta']['subtitle'] ?? null))
                <p class="text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed">
                    {!! nl2br(e($section['content']['meta']['subtitle'])) !!}
                </p>
            @endif

            <div class="flex flex-col sm:flex-row gap-4">
                @if(!empty($section['content']['meta']['button 1']['label'] ?? null))
                    <a href="{{ $section['content']['meta']['button 1']['url'] ?? '#' }}"
                        class="group px-8 py-4 bg-teal-600 text-white rounded-xl font-semibold text-lg hover:bg-teal-700 transition-all hover:shadow-lg hover:shadow-teal-600/30 flex items-center justify-center gap-2">
                        <x-lucide-search class="w-[22px] h-[22px]" />
                        {{ $section['content']['meta']['button 1']['label'] }}
                        <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                @endif

                @if(!empty($section['content']['meta']['button 2']['label'] ?? null))
                    <a href="{{ $section['content']['meta']['button 2']['url'] ?? '#' }}"
                        class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/20 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                        <x-lucide-briefcase class="w-[22px] h-[22px]" />
                        {{ $section['content']['meta']['button 2']['label'] }}
                    </a>
                @endif
            </div>

            {{-- Stats --}}
            @if(!empty($section['content']['meta']['widget'] ?? null))
                <div class="grid grid-cols-3 gap-6 mt-16 pt-8 border-t border-white/10">
                    @foreach($section['content']['meta']['widget'] as $label => $value)
                        <div>
                            <div class="text-3xl md:text-4xl font-bold text-teal-400 mb-1">{{ $value }}</div>
                            <div class="text-sm md:text-base text-gray-400 capitalize">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>