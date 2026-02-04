<footer class="bg-gray-900 text-gray-300">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- About Section --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    {{-- <img src="{{ cdn_asset('shared/logo-png.png') }}" class="h-12 w-12 object-contain"
                        loading="lazy" alt="logo ponorogo"
                        referrerpolicy="{{ app()->isLocal() ? 'no-referrer' : 'strict-origin-when-cross-origin' }}" />
                    --}}
                    <div>
                        <h3 class="text-white font-bold text-lg">
                            {{ $about['meta']['organization'] ?? 'Disnaker Ponorogo' }}
                        </h3>
                        <p class="text-sm text-gray-400">
                            {{ $about['meta']['title'] ?? 'Dinas Tenaga Kerja' }}
                        </p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-pretty">
                    {{ $about['meta']['subtitle'] ?? 'Pusat informasi dan layanan ketenagakerjaan Kabupaten Ponorogo.' }}
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Link Cepat</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('index') }}" class="text-sm hover:text-teal-400 transition-colors">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bale.post-list') }}" class="text-sm hover:text-teal-400 transition-colors">
                            Berita & Pengumuman
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bale.jobs') }}" class="text-sm hover:text-teal-400 transition-colors">
                            Lowongan Kerja
                        </a>
                    </li>
                    @if(!empty($footer['meta']['link cepat']) && is_array($footer['meta']['link cepat']))
                        @foreach($footer['meta']['link cepat'] as $label => $link)
                            <li>
                                <a href="{{ $link['url'] ?? '#' }}" class="text-sm hover:text-teal-400 transition-colors">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Layanan Kami</h4>
                <ul class="space-y-2">
                    @if(!empty($footer['meta']['layanan kami']) && is_array($footer['meta']['layanan kami']))
                        @foreach($footer['meta']['layanan kami'] as $label => $service)
                            <li>
                                <a href="{{ $service['url'] ?? '#' }}" class="text-sm hover:text-teal-400 transition-colors">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="text-sm text-gray-500 italic">Belum ada layanan tersedia</li>
                    @endif
                </ul>
            </div>

            {{-- Contact Info --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Kontak Kami</h4>
                @if(!empty($footer['meta']['kontak kami']))
                    @php $kontak = $footer['meta']['kontak kami']; @endphp
                    <ul class="space-y-3">
                        @if(!empty($kontak['address']))
                            <li class="flex items-start gap-3">
                                <x-lucide-map-pin class="w-[18px] h-[18px] text-teal-400 mt-1 shrink-0" />
                                <span class="text-sm">{{ $kontak['address'] }}</span>
                            </li>
                        @endif
                        @if(!empty($kontak['phone']))
                            <li class="flex items-center gap-3">
                                <x-lucide-phone class="w-[18px] h-[18px] text-teal-400 shrink-0" />
                                <span class="text-sm">{{ $kontak['phone'] }}</span>
                            </li>
                        @endif
                        @if(!empty($kontak['email']))
                            <li class="flex items-center gap-3">
                                <x-lucide-mail class="w-[18px] h-[18px] text-teal-400 shrink-0" />
                                <span class="text-sm">{{ $kontak['email'] }}</span>
                            </li>
                        @endif
                    </ul>
                @else
                    <p class="text-sm text-gray-500 italic">Informasi kontak tidak tersedia</p>
                @endif

                {{-- Social Media --}}
                @if(!empty($footer['meta']['socials']) && is_array($footer['meta']['socials']))
                    <div class="flex gap-4 mt-6">
                        @foreach($footer['meta']['socials'] as $key => $social)
                            @if(!empty($social['enabled']) && !empty($social['url']))
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-teal-600 transition-colors"
                                    aria-label="{{ ucfirst($key) }}">
                                    <x-dynamic-component :component="'lucide-' . ($social['icon'] ?? 'link')"
                                        class="w-[18px] h-[18px]" />
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-800 mt-8 pt-6 text-center">
            <p class="text-sm text-gray-400">
            <p>&copy; Bale CMS {{date('Y')}}. Template By Dinas Kominfo dan Statistik Kabupaten Ponorogo</p>
            </p>
        </div>
    </div>
</footer>