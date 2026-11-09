<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    <x-bale-disnaker::header-page :title="__('Pelatihan')" :breadcrumbs="[['label' => __('Pelatihan')]]"
        :subtitle="__('Permintaan pelatihan kerja Dinas Tenaga Kerja Kabupaten Ponorogo')" />

    <section class="py-12 md:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl space-y-6">

                @if(! $period)
                    <div class="rounded-3xl border border-gray-100 bg-white p-8 text-center shadow-sm dark:border-slate-800 dark:bg-slate-800">
                        <span class="mx-auto flex size-12 items-center justify-center rounded-full bg-teal-50 text-teal-500 dark:bg-teal-900/20">
                            <x-umpak::icon name="calendar-x" class="size-6" />
                        </span>
                        <h2 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">{{ __('Belum ada periode pelatihan') }}</h2>
                        <p class="mx-auto mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Pengajuan permintaan pelatihan dibuka pada periode tertentu. Silakan cek kembali nanti.') }}
                        </p>
                    </div>
                @else
                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800">
                        <p class="text-xs font-bold uppercase tracking-wider text-teal-600 dark:text-teal-400">{{ __('Periode Aktif') }}</p>
                        <h2 class="mt-1 text-xl font-bold text-gray-900 dark:text-white">{{ $period->name }} · {{ $period->year }}</h2>
                        @if($period->description)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $period->description }}</p>
                        @endif
                    </div>

                    @if(config('tala.enabled'))
                    @guest('tala')
                        <div class="rounded-3xl border border-teal-100 bg-teal-50/60 p-6 text-center dark:border-teal-900/40 dark:bg-teal-900/10">
                            <p class="text-sm font-medium text-teal-800 dark:text-teal-200">
                                {{ __('Masuk dengan akun SSO warga untuk mengirim permintaan pelatihan.') }}
                            </p>
                            <a href="{{ route('tala.redirect') }}"
                                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-teal-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700">
                                <x-umpak::icon name="log-in" class="size-4" />
                                {{ __('Masuk') }}
                            </a>
                        </div>
                    @endguest

                    @auth('tala')
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach ([
        ['route' => 'disnaker.pelatihan.masyarakat', 'icon' => 'user-round', 'title' => __('Masyarakat'), 'desc' => __('Ajukan kebutuhan pelatihan untuk diri sendiri.')],
        ['route' => 'disnaker.pelatihan.perusahaan', 'icon' => 'building-2', 'title' => __('Perusahaan'), 'desc' => __('Ajukan kebutuhan pelatihan untuk tenaga kerja perusahaan.')],
    ] as $card)
                                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800">
                                    <span class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white shadow-md shadow-teal-500/25">
                                        <x-umpak::icon :name="$card['icon']" class="size-5" />
                                    </span>
                                    <h3 class="mt-4 text-base font-bold text-gray-900 dark:text-white">{{ $card['title'] }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $card['desc'] }}</p>

                                    @if(Route::has($card['route']))
                                        <a href="{{ route($card['route']) }}" wire:navigate
                                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-teal-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                                            {{ __('Isi Formulir') }}
                                            <x-umpak::icon name="arrow-right" class="size-4" />
                                        </a>
                                    @else
                                        <p class="mt-4 text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Formulir segera dibuka.') }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endauth
                    @endif
                @endif
            </div>
        </div>
    </section>
</div>
