@props(['posts', 'currentId' => null])

<aside class="lg:sticky lg:top-28">
    <h3 class="text-xl font-bold text-teal-600 dark:text-white mb-6 flex items-center gap-2">
        <span class="w-1 h-6 bg-teal-600 rounded-full"></span>
        Berita Lainnya
    </h3>

    <div class="space-y-6">
        @forelse ($posts as $suggested)
            <a href="{{ route('bale.view-post', $suggested->slug) }}" wire:navigate.hover
                class="group flex gap-4 bg-white dark:bg-slate-800 p-3 rounded-xl border border-gray-100 dark:border-slate-700 hover:border-teal-600 transition-all duration-300 shadow-sm hover:shadow-md">
                <div class="w-24 h-24 shrink-0 rounded-lg overflow-hidden">
                    @if ($suggested->hasThumbnail())
                        <x-umpak::cdn-img :path="$suggested->thumbnail" alt=""
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    @else
                        <div class="w-full h-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                            <x-umpak::icon name="image" class="w-8 h-8 text-gray-400" />
                        </div>
                    @endif
                </div>
                <div class="flex flex-col justify-center py-1">
                    <span class="text-[10px] font-bold text-teal-600/60 dark:text-teal-400 uppercase tracking-wider mb-1">
                        {{ $suggested->formattedDate() }}
                    </span>
                    <h4
                        class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-teal-600 transition-colors duration-300 leading-tight">
                        {{ $suggested->title }}
                    </h4>
                </div>
            </a>
        @empty
            <p class="text-sm text-gray-500 italic">Tidak ada berita lain ditemukan.</p>
        @endforelse
    </div>
</aside>
