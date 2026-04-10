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
                    <div class="mt-12 flex justify-end">
                        <x-emperan::share-button :url="route('bale.view-page', $page->slug)" :title="$page->title"
                            :text="$page->getExcerpt(160)" />
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