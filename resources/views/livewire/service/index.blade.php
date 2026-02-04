<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    {{-- Header --}}
    <x-bale-disnaker::header-page :title="$meta['title']" :subtitle="$meta['subtitle']" :breadcrumbs="[['label' => $meta['title']]]" />

    {{-- Services Grid --}}
    <section class="py-12 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach ($services as $index => $service)
                    <a href="{{ $service['url'] }}"
                        class="group relative block bg-white dark:bg-slate-800 rounded-2xl p-8 border border-gray-200 dark:border-slate-700 hover:border-transparent hover:shadow-2xl transition-all duration-300 overflow-hidden"
                        style="animation-delay: {{ $index * 100 }}ms">

                        {{-- Background Gradient on Hover --}}
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-opacity duration-300 rounded-2xl"
                            style="background: linear-gradient(135deg, {{ $service['color'] }}20 0%, {{ $service['color'] }}05 100%)">
                        </div>

                        {{-- Icon --}}
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110"
                            style="background-color: {{ $service['color'] }}15; color: {{ $service['color'] }}">
                            <x-dynamic-component :component="'lucide-' . $service['icon']" class="w-8 h-8" />
                        </div>

                        {{-- Content --}}
                        <h3
                            class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-teal-700 dark:group-hover:text-teal-400 transition-colors">
                            {{ $service['title'] }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $service['description'] }}
                        </p>

                        {{-- Decorative Element --}}
                        <div class="absolute bottom-0 right-0 w-24 h-24 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"
                            style="background-color: {{ $service['color'] }}"></div>
                    </a>
                @endforeach
            </div>

            {{-- CTA Section --}}
            <div class="mt-16 text-center">
                <div
                    class="inline-block bg-linear-to-r from-teal-50 to-blue-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl p-8 md:p-12 max-w-4xl w-full">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $meta['bantuan']['title'] }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-xl mx-auto">
                        {{ $meta['bantuan']['subtitle'] }}
                    </p>
                    <a href="{{ $meta['bantuan']['button']['url'] }}"
                        class="inline-block px-8 py-4 bg-teal-600 text-white rounded-xl font-semibold hover:bg-teal-700 transition-colors shadow-lg hover:shadow-xl">
                        {{ $meta['bantuan']['button']['label'] }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>