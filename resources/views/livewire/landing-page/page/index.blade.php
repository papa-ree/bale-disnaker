<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    {{-- header --}}
    <x-bale-disnaker::header-page :title="$page->title" :breadcrumbs="[['label' => $page->title]]"
        :subtitle="$page->excerpt" />

    {{-- Page Content Section --}}
    <section class="py-12 md:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">

                {{-- Page Content --}}
                <article
                    class="bg-white dark:bg-slate-800 rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 dark:border-slate-800">
                    <div class="prose prose-lg prose-teal dark:prose-invert max-w-none">
                        @if($page->content)
                            <x-emperan::editorjs-renderer :content="$page->content" />
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Tidak ada konten untuk ditampilkan.
                            </p>
                        @endif
                    </div>

                    {{-- Share Actions --}}
                    <div
                        class="mt-12 pt-8 border-t border-gray-100 dark:border-slate-700 flex flex-wrap items-center justify-between gap-6">
                        <div x-data="{
                            copied: false,
                            share() {
                                const text = `${@js($page->title)}\n\n${@js($page->excerpt)}\n\nInfo lebih lanjut: ${@js(route('bale.view-page', $page->slug))}`;
                                if (navigator.share) {
                                    navigator.share({
                                        title: @js($page->title),
                                        text: text,
                                        url: @js(route('bale.view-page', $page->slug))
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
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 dark:bg-slate-700/50 hover:bg-teal-600/10 dark:hover:bg-teal-600/20 text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition-all duration-300 group/btn font-semibold">
                                <div class="relative">
                                    <svg x-show="!copied" class="w-5 h-5 transition-transform group-hover/btn:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                        </path>
                                    </svg>
                                    <svg x-show="copied" x-cloak class="w-5 h-5 text-green-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span x-text="copied ? 'Tersalin!' : 'Bagikan Halaman'" class="text-sm"></span>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="https://wa.me/?text={{ urlencode($page->title . ' - ' . route('bale.view-page', $page->slug)) }}"
                                target="_blank"
                                class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-all hover:scale-110 shadow-lg shadow-green-500/20">
                                <x-lucide-phone class="w-5 h-5 fill-current" />
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('bale.view-page', $page->slug)) }}"
                                target="_blank"
                                class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all hover:scale-110 shadow-lg shadow-blue-600/20">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Navigation --}}
                <div class="mt-12 text-center">
                    <a href="{{ route('index') }}" wire:navigate.hover
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 text-teal-600 dark:text-teal-400 hover:bg-teal-600 hover:text-white dark:hover:bg-teal-600 transition-all duration-300 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm font-semibold">
                        <x-lucide-arrow-left class="w-5 h-5" />
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>