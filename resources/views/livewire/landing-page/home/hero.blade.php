@if (empty($section) || empty($this->meta))
    {{-- Error Handler: Section Not Found --}}
    <x-emperan::section-error title="Konten Hero Tidak Ditemukan"
        message="Silakan konfigurasi section 'hero-section' di panel admin CMS agar konten halaman utama dapat ditampilkan." />
@else
    @php
        $meta = $this->meta;
        $background = $meta['background'] ?? null;
        $images = $background['images'] ?? [];
        $organization = $meta['custom']['organization_name'] ?? null;
        $buttons = array_values(array_filter($meta['buttons'] ?? [], fn($b) => $b['show'] ?? true));
        $stats = $this->stats;

        // Primary background image (first in array)
        $bgImage = $images[0]['cdn_url'] ?? ($images[0]['path'] ?? null);
        $altText = $meta['title'] ?? 'Tenaga kerja profesional';
    @endphp

    <section class="relative min-h-screen flex items-center overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            @if ($bgImage)
                <img src="{{ Str::startsWith($bgImage, 'http') ? $bgImage : cdn_asset($bgImage) }}" alt="{{ $altText }}"
                    class="w-full h-full object-cover" />
            @endif
            <div class="absolute inset-0 bg-linear-to-r from-gray-900/95 via-gray-900/85 to-teal-900/75"></div>
        </div>

        {{-- Peacock Accent Elements --}}
        <div class="absolute top-20 right-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>

        {{-- Content --}}
        <div class="container mx-auto px-4 py-24 relative z-10">
            <div class="max-w-3xl">

                {{-- ORGANIZATION BADGE --}}
                @if ($organization)
                    <div class="inline-block mb-6">
                        <span
                            class="px-4 py-2 bg-teal-600/20 border border-teal-400/30 text-teal-300 rounded-full text-sm font-medium backdrop-blur-sm">
                            {{ $organization }}
                        </span>
                    </div>
                @endif

                {{-- TITLE --}}
                @if (!empty($meta['title']))
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        {!! nl2br(e($meta['title'])) !!}
                    </h1>
                @endif

                {{-- SUBTITLE --}}
                @if (!empty($meta['subtitle']))
                    <p class="text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed">
                        {!! nl2br(e($meta['subtitle'])) !!}
                    </p>
                @endif

                {{-- BUTTONS --}}
                @if (!empty($buttons))
                    <div class="flex flex-col sm:flex-row gap-4">
                        @foreach ($buttons as $index => $button)
                            @if ($index === 0)
                                <a href="{{ $button['url'] ?? '#' }}" {{ $button['navigate'] ?? '' }}
                                    @if(!empty($button['target'])) target="{{ $button['target'] }}" rel="noopener noreferrer" @endif
                                    class="group px-8 py-4 bg-teal-600 text-white rounded-xl font-semibold text-lg hover:bg-teal-700 transition-all hover:shadow-lg hover:shadow-teal-600/30 flex items-center justify-center gap-2">
                                    @if (!empty($button['icon']))
                                        <x-dynamic-component :component="'lucide-' . $button['icon']" class="w-[22px] h-[22px]" />
                                    @else
                                        <x-lucide-search class="w-[22px] h-[22px]" />
                                    @endif
                                    {{ $button['label'] }}
                                    <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                                </a>
                            @else
                                <a href="{{ $button['url'] ?? '#' }}" {{ $button['navigate'] ?? '' }}
                                    @if(!empty($button['target'])) target="{{ $button['target'] }}" rel="noopener noreferrer" @endif
                                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/20 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                                    @if (!empty($button['icon']))
                                        <x-dynamic-component :component="'lucide-' . $button['icon']" class="w-[22px] h-[22px]" />
                                    @else
                                        <x-lucide-briefcase class="w-[22px] h-[22px]" />
                                    @endif
                                    {{ $button['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- STATS --}}
                @if (!empty($stats))
                    <div class="grid grid-cols-3 gap-6 mt-16 pt-8 border-t border-white/10">
                        @foreach ($stats as $stat)
                            <div>
                                <div class="text-3xl md:text-4xl font-bold text-teal-400 mb-1">{{ $stat['value'] }}</div>
                                <div class="text-sm md:text-base text-gray-400 capitalize">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </section>
@endif