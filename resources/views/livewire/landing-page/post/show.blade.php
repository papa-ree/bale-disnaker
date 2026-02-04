<div class="min-h-screen bg-gray-50 dark:bg-slate-900">

    {{-- Main Content Section --}}
    <section class="py-12 md:py-16" wire:cloak>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                    {{-- Left Column: Post detail --}}
                    <div class="lg:col-span-8">
                        {{-- Back to News Button and sharing --}}
                        {{-- <div class="flex justify-between mb-8">
                            <div>
                                <a href="{{ route('bale.post-list') }}" wire:navigate.hover
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 text-teal-600 dark:text-teal-400 hover:bg-teal-600 hover:text-white dark:hover:bg-teal-600 transition-all duration-300 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm font-semibold">
                                    <x-lucide-arrow-left class="w-5 h-5" />
                                    Kembali ke Semua Berita
                                </a>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-6">
                                <div x-data="{
                                    copied: false,
                                    share() {
                                        const text = `{{ $post->title }}\n\n{{ $post->excerpt(160) }}\n\nInfo lebih lanjut: {{ route('bale.view-post', $post->slug) }}`;
                                        if (navigator.share) {
                                            navigator.share({
                                                title: '{{ $post->title }}',
                                                text: text,
                                                url: '{{ route('bale.view-post', $post->slug) }}'
                                            }).catch(console.error);
                                        } else {
                                            navigator.clipboard.writeText(text).then(() => {
                                                this.copied = true;
                                                setTimeout(() => this.copied = false, 2000);
                                            });
                                        }
                                    }
                                }">
                                    <button @click="share" 
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-slate-700/50 hover:bg-teal-600/10 dark:hover:bg-teal-600/20 text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition-all duration-300 group/btn font-semibold">
                                        <div class="relative">
                                            <svg x-show="!copied" class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                            </svg>
                                            <svg x-show="copied" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span x-text="copied ? 'Tersalin!' : 'Bagikan Berita'" class="text-sm"></span>
                                    </button>
                                </div>
                            </div>
                        </div> --}}

                        <article class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-800 overflow-hidden text-justify">
                            @if ($post->thumbnail)
                                <img src="{{ cdn_asset('thumbnails/' . $post->thumbnail) }}"
                                    alt="{{ $post->title }}" class="w-full h-96 object-cover" />
                            @else
                                <div class="bg-gray-100 dark:bg-slate-800 flex items-center justify-center h-96 border-b border-gray-100 dark:border-slate-800">
                                    <svg class="w-20 h-20 text-gray-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-8 md:p-12">
                                <div class="flex flex-wrap items-center gap-4 mb-6">
                                    @if($post->category)
                                        <span class="px-3 py-1 bg-teal-600/10 text-teal-600 dark:text-teal-400 text-sm font-bold rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                    <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm">
                                        <x-lucide-calendar class="w-4 h-4" />
                                        <span>{{ $post->created_at }}</span>
                                    </div>
                                    {{-- <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm">
                                        <x-lucide-eye class="w-4 h-4" />
                                        <span>{{ number_format($post->views ?? 0) }} Views</span>
                                    </div> --}}
                                </div>

                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                    {{ $post->title }}
                                </h1>

                                <div class="prose prose-lg prose-teal dark:prose-invert max-w-none">
                                    @if ($post->content)
                                        <x-emperan::editorjs-renderer :content="$post->content" />
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                            Tidak ada konten untuk ditampilkan.
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center justify-end gap-6 mt-12">
                                    <div x-data="{
                                        copied: false,
                                        share() {
                                            const text = `${@js($post->title)}\n\n${@js($post->excerpt(160))}\n\nInfo lebih lanjut: ${@js(route('bale.view-post', $post->slug))}`;
                                            if (navigator.share) {
                                                navigator.share({
                                                    title: @js($post->title),
                                                    text: text,
                                                    url: @js(route('bale.view-post', $post->slug))
                                                }).catch(console.error);
                                            } else {
                                                navigator.clipboard.writeText(text).then(() => {
                                                    this.copied = true;
                                                    setTimeout(() => this.copied = false, 2000);
                                                });
                                            }
                                        }
                                    }">
                                        <button @click="share" 
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-slate-700/50 hover:bg-teal-600/10 dark:hover:bg-teal-600/20 text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition-all duration-300 group/btn font-semibold">
                                            <div class="relative">
                                                <svg x-show="!copied" class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                </svg>
                                                <svg x-show="copied" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span x-text="copied ? 'Tersalin!' : 'Bagikan Berita'" class="text-sm"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <div class="flex justify-between mt-8">
                            <div>
                                <a href="{{ route('bale.post-list') }}" wire:navigate.hover
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 text-teal-600 dark:text-teal-400 hover:bg-teal-600 hover:text-white dark:hover:bg-teal-600 transition-all duration-300 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm font-semibold">
                                    <x-lucide-arrow-left class="w-5 h-5" />
                                    Kembali ke Semua Berita
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Sidebar (Suggested Posts) --}}
                    <div class="lg:col-span-4">
                        <x-bale-disnaker::suggested-posts :posts="$this->suggestedPosts" :currentId="$post->id" />
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>