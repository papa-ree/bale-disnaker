@php
    $section = $this->sectionData;
@endphp

@if ($section)
    @php
        $title       = $section->meta('title', 'Berita Terbaru');
        $subtitle    = $section->meta('subtitle');
        $buttonLabel = $section->meta('button.label', 'Lihat Semua Berita');
        $buttonUrl   = $section->meta('button.url', route('bale.post-list'));
        if ($buttonUrl === '#') {
            $buttonUrl = route('bale.post-list');
        }
    @endphp

    <section class="py-20 bg-linear-to-b from-gray-50 to-white dark:from-slate-900 dark:to-slate-800">
        <div data-aos="fade-up">
            <div class="container max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $title }}
                    </h2>
                    @if ($subtitle)
                        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" data-aos="fade-up"
                    data-aos-offset="200" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true">
                    @foreach ($posts as $index => $post)
                        <article wire:key='{{ $post->id }}'
                            class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-slate-700"
                            style="animation-delay: {{ $index * 150 }}ms">
                            <a href="{{ route('bale.view-post', $post->slug) }}" class="block">
                                {{-- Image --}}
                                <div class="relative h-56 overflow-hidden">
                                    @if ($post->hasThumbnail())
                                        <x-umpak::cdn-img :path="$post->thumbnail" :alt="$post->title"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <div
                                            class="w-full h-full group-hover:scale-150 transition-transform duration-500 bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                            <x-umpak::icon name="image" class="w-8 h-8 text-gray-400" />
                                        </div>
                                    @endif
                                    @if ($post->categorySlug)
                                        <div class="absolute top-4 left-4">
                                            <span class="px-3 py-1 bg-teal-600 text-white text-xs font-semibold rounded-full">
                                                {{ $post->categorySlug }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                {{-- Content --}}
                                <div class="p-6">
                                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
                                        <x-umpak::icon name="calendar" class="w-4 h-4" />
                                        <span>{{ $post->formattedDate() }}</span>
                                    </div>

                                    <h3
                                        class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-teal-700 transition-colors leading-snug line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                        {{ $post->excerpt }}
                                    </p>

                                    <span
                                        class="inline-flex items-center gap-2 text-teal-600 font-semibold hover:text-teal-700 transition-colors group/link">
                                        Baca Selengkapnya
                                        <x-umpak::icon name="arrow-right"
                                            class="w-[18px] h-[18px] group-hover/link:translate-x-1 transition-transform" />
                                    </span>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                {{-- View All Button --}}
                <div class="text-center" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <a href="{{ $buttonUrl }}" wire:navigate.hover
                        class="inline-block px-8 py-4 bg-teal-600 text-white rounded-xl font-semibold text-lg hover:bg-teal-700 transition-colors shadow-lg hover:shadow-xl">
                        {{ $buttonLabel }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@else
    <x-umpak::section-error name="Berita Utama" />
@endif
