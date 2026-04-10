<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;

class ServicesSection extends Component
{
    public string $slug = 'service-section';
    public array $section = [];
    public $actived;

    public function mount(?string $slug = null)
    {
        if ($slug) {
            $this->slug = $slug;
        }

        $sectionModel = Section::whereSlug($this->slug)->first();

        $this->section = $sectionModel?->content ?? [];
        $this->actived = $sectionModel?->actived ?? false;
    }

    #[Computed]
    public function meta()
    {
        $defaultMeta = [
            'title' => 'Layanan Kami',
            'subtitle' => 'Solusi tenaga kerja komprehensif yang dirancang untuk memberdayakan pencari kerja dan pemberi kerja.',
            'custom' => [
                'columns' => 3,
                'icon_style' => 'outline',
                'judul_bantuan' => 'Butuh bantuan dengan layanan kami?',
                'deskripsi_bantuan' => 'Tim kami siap membantu Anda dengan layanan ketenagakerjaan, program pelatihan, dan solusi tenaga kerja.'
            ],
            'buttons' => []
        ];

        $contentMeta = $this->section['meta'] ?? [];

        // Gabungkan seluruh data, jangan dibatasi dengan array_intersect_key
        $meta = array_merge($defaultMeta, $contentMeta);

        // Merge array custom secara terpisah agar keys default-nya tetap ada
        if (isset($contentMeta['custom']) && is_array($contentMeta['custom'])) {
            $meta['custom'] = array_merge($defaultMeta['custom'], $contentMeta['custom']);
        }

        // Tumpukkan eksplisit untuk index-based array agar array_merge tidak menyebabkan elemen terduplikat (append)
        if (isset($contentMeta['buttons']) && is_array($contentMeta['buttons'])) {
            $meta['buttons'] = collect($contentMeta['buttons'])->map(function ($button) {
                $rawUrl = $button['url'] ?? '#';
                $isExternal = str_starts_with($rawUrl, 'http');
                $button['url'] = $isExternal || $rawUrl === '#' ? $rawUrl : url($rawUrl);
                $button['navigate'] = !$isExternal && $rawUrl !== '#' ? 'wire:navigate.hover' : '';
                $button['target'] = $isExternal ? '_blank' : '';
                return $button;
            })->toArray();
        }

        return $meta;
    }

    #[Computed]
    public function services()
    {
        $items = $this->section['items'] ?? [];
        $order = $this->section['meta']['order'] ?? ['url', 'icon', 'judul', 'deskripsi'];

        $urlKey = $order[0] ?? 'url';
        $iconKey = $order[1] ?? 'icon';
        $titleKey = $order[2] ?? 'judul';
        $descKey = $order[3] ?? 'deskripsi';

        $colors = ["#008080", "#20B2AA", "#4169E1", "#3CB371", "#2E8B57", "#5F9EA0"];

        $services = collect($items)->map(function ($item, $index) use ($colors, $urlKey, $iconKey, $titleKey, $descKey) {
            $title = is_array($item[$titleKey] ?? null) ? ($item[$titleKey][0] ?? '') : ($item[$titleKey] ?? '');
            $description = is_array($item[$descKey] ?? null) ? ($item[$descKey][0] ?? '') : ($item[$descKey] ?? '');
            $icon = is_array($item[$iconKey] ?? null) ? ($item[$iconKey][0] ?? 'circle') : ($item[$iconKey] ?? 'circle');
            $rawUrl = is_array($item[$urlKey] ?? null) ? ($item[$urlKey][0] ?? '#') : ($item[$urlKey] ?? '#');
            $isExternal = str_starts_with($rawUrl, 'http');
            $url = $isExternal || $rawUrl === '#' ? $rawUrl : url($rawUrl);
            $navigate = !$isExternal && $rawUrl !== '#' ? 'wire:navigate.hover' : '';
            $target = $isExternal ? '_blank' : '';

            return [
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'url' => $url,
                'is_external' => $isExternal,
                'navigate' => $navigate,
                'target' => $target,
                'color' => $colors[$index % count($colors)]
            ];
        });

        // Ensure "Lainnya" is at the end if it exists
        $others = $services->filter(fn($item) => strtolower($item['title']) === 'lainnya');
        $mainServices = $services->reject(fn($item) => strtolower($item['title']) === 'lainnya');

        return $mainServices->concat($others);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.services-section');
    }
}
