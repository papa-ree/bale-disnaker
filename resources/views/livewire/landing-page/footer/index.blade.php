<footer class="bg-gray-950 text-gray-300 pt-20 pb-10">
    <div class="container mx-auto px-4">
        @if (empty($footer) || empty($this->meta))
            <x-emperan::section-error title="Konten Footer Tidak Ditemukan"
                message="Silakan konfigurasi section 'footer-section' di panel admin CMS." />
        @else
            @php
                $aboutMeta = $about['meta'] ?? [];
                $groupedLinks = $this->groupedLinks;
                $contact = $this->contact;
                $socials = $this->socials;
                $meta = $this->meta;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- About Section --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div>
                            <h3 class="text-white font-bold text-lg">
                                {{ $aboutMeta['custom']['organization_name'] ?? ($aboutMeta['organization'] ?? 'Disnaker Ponorogo') }}
                            </h3>
                            <p class="text-sm text-gray-400">
                                {{ $aboutMeta['title'] ?? 'Dinas Tenaga Kerja' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-pretty">
                        {{ $aboutMeta['subtitle'] ?? 'Pusat informasi dan layanan ketenagakerjaan Kabupaten Ponorogo.' }}
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Link Cepat</h4>
                    <ul class="space-y-2">
                        {{-- From Database --}}
                        @if(!empty($groupedLinks['quick link']))
                            @foreach($groupedLinks['quick link'] as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-sm hover:text-teal-400 transition-colors">
                                        {{ $link['label'] }}
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
                        @if(!empty($groupedLinks['services']))
                            @foreach($groupedLinks['services'] as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-sm hover:text-teal-400 transition-colors">
                                        {{ $link['label'] }}
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
                    @if(!empty($contact))
                        <ul class="space-y-3">
                            @if(!empty($contact['address']))
                                <li class="flex items-start gap-3">
                                    <x-lucide-map-pin class="w-[18px] h-[18px] text-teal-400 mt-1 shrink-0" />
                                    <span class="text-sm">{{ $contact['address'] }}</span>
                                </li>
                            @endif
                            @if(!empty($contact['phone']))
                                <li class="flex items-center gap-3">
                                    <x-lucide-phone class="w-[18px] h-[18px] text-teal-400 shrink-0" />
                                    <span class="text-sm">{{ $contact['phone'] }}</span>
                                </li>
                            @endif
                            @if(!empty($contact['email']))
                                <li class="flex items-center gap-3">
                                    <x-lucide-mail class="w-[18px] h-[18px] text-teal-400 shrink-0" />
                                    <span class="text-sm">{{ $contact['email'] }}</span>
                                </li>
                            @endif
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 italic">Informasi kontak tidak tersedia</p>
                    @endif

                    @if(!empty($socials))
                        <div class="flex gap-4 mt-6">
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-teal-600 transition-colors"
                                    aria-label="{{ $social['name'] }}">
                                    <span
                                        class="w-[18px] h-[18px] flex items-center justify-center [&>svg]:w-[18px] [&>svg]:h-[18px]">
                                        @if($social['icon'])
                                            {!! $social['icon'] !!}
                                        @else
                                            <x-lucide-link class="w-[18px] h-[18px]" />
                                        @endif
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-20 pt-8 border-t border-gray-900 text-center">
                <p>&copy; Bale CMS {{ date('Y') }}. Template By Dinas Kominfo dan Statistik Kabupaten Ponorogo</p>
            </div>
        @endif
    </div>
</footer>