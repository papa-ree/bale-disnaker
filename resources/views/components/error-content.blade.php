@props([
    'code' => '404',
    'title' => 'Halaman Tidak Ditemukan',
    'message' => 'Maaf, halaman yang Anda cari tidak dapat ditemukan.',
])

<section class="relative py-20 px-4 min-h-[60vh] flex items-center">
    {{-- Background Decorative Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-teal-500/10 dark:bg-teal-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 dark:bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto relative z-10">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Glassmorphism Card --}}
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 md:p-12 border border-gray-200/50 dark:border-slate-700/50 shadow-xl">
                
                {{-- Error Icon --}}
                <div class="mb-6">
                    @switch($code)
                        @case('401')
                        @case('403')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                                <x-lucide-shield-off class="w-10 h-10 text-red-600 dark:text-red-400" />
                            </div>
                            @break
                        @case('402')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-100 dark:bg-amber-900/30 rounded-full mb-4">
                                <x-lucide-credit-card class="w-10 h-10 text-amber-600 dark:text-amber-400" />
                            </div>
                            @break
                        @case('419')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-100 dark:bg-orange-900/30 rounded-full mb-4">
                                <x-lucide-clock class="w-10 h-10 text-orange-600 dark:text-orange-400" />
                            </div>
                            @break
                        @case('429')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 rounded-full mb-4">
                                <x-lucide-zap class="w-10 h-10 text-yellow-600 dark:text-yellow-400" />
                            </div>
                            @break
                        @case('500')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                                <x-lucide-alert-triangle class="w-10 h-10 text-red-600 dark:text-red-400" />
                            </div>
                            @break
                        @case('503')
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-4">
                                <x-lucide-settings class="w-10 h-10 text-blue-600 dark:text-blue-400" />
                            </div>
                            @break
                        @default
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-teal-100 dark:bg-teal-900/30 rounded-full mb-4">
                                <x-lucide-file-search class="w-10 h-10 text-teal-600 dark:text-teal-400" />
                            </div>
                    @endswitch
                </div>

                {{-- Error Code --}}
                <h1 class="text-7xl md:text-8xl font-bold mb-4 bg-linear-to-r from-teal-600 via-teal-500 to-blue-500 bg-clip-text text-transparent">
                    {{ $code }}
                </h1>

                {{-- Error Title --}}
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ $title }}
                </h2>

                {{-- Error Message --}}
                <p class="text-gray-600 dark:text-slate-400 mb-8 max-w-md mx-auto leading-relaxed">
                    {{ $message }}
                </p>

                {{-- Back Button --}}
                <a href="/" wire:navigate
                    class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold px-8 py-3 rounded-full shadow-lg shadow-teal-600/25 hover:shadow-xl hover:shadow-teal-700/30 transition-all duration-300 transform hover:-translate-y-0.5">
                    <x-lucide-home class="w-5 h-5" />
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
