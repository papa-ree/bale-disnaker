<section class="py-20 bg-linear-to-b from-gray-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div data-aos="fade-up">
        <div class="container max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                @if(!empty($section['content']['meta']['title'] ?? null))
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $section['content']['meta']['title'] }}
                    </h2>
                @endif
                @if(!empty($section['content']['meta']['subtitle'] ?? null))
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        {{ $section['content']['meta']['subtitle'] }}
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
                                @if ($post->thumbnail)
                                    <img src="{{ cdn_asset('thumbnails/' . $post->thumbnail) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        loading="lazy" />
                                @else
                                    <div
                                        class="w-full h-full group-hover:scale-150 transition-transform duration-500 bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if($post?->category?->name)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-teal-600 text-white text-xs font-semibold rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            {{-- Content --}}
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    <x-lucide-calendar class="w-4 h-4" />
                                    <span>{{ $post->created_at }}</span>
                                </div>

                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-teal-700 transition-colors leading-snug line-clamp-2">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $post->excerpt(120) }}
                                </p>

                                <span
                                    class="inline-flex items-center gap-2 text-teal-600 font-semibold hover:text-teal-700 transition-colors group/link">
                                    Read Full Article
                                    <x-lucide-arrow-right
                                        class="w-[18px] h-[18px] group-hover/link:translate-x-1 transition-transform" />
                                </span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            {{-- View All Button --}}
            @php
                $buttonLabel = $section['content']['meta']['button']['label'] ?? 'View All News';
                $buttonUrl = $section['content']['meta']['button']['url'] ?? route('bale.post-list');
                if ($buttonUrl === '#')
                    $buttonUrl = route('bale.post-list');
            @endphp
            <div class="text-center" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                <a href="{{ $buttonUrl }}" wire:navigate.hover
                    class="inline-block px-8 py-4 bg-teal-600 text-white rounded-xl font-semibold text-lg hover:bg-teal-700 transition-colors shadow-lg hover:shadow-xl">
                    {{ $buttonLabel }}
                </a>
            </div>
        </div>
    </div>
</section>