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
            'title' => 'Our Services',
            'subtitle' => 'Comprehensive workforce solutions designed to empower both job seekers and employers',
            'bantuan' => [
                'title' => 'Need Help with Our Services?',
                'subtitle' => 'Our team is ready to assist you with employment services, training programs, and workforce solutions.',
                'button' => [
                    'label' => 'Contact Us Today',
                    'url' => '#contact'
                ]
            ]
        ];

        $contentMeta = $this->section['meta'] ?? [];

        $meta = array_merge($defaultMeta, array_intersect_key($contentMeta, $defaultMeta));

        if (isset($contentMeta['bantuan'])) {
            $meta['bantuan'] = array_merge($defaultMeta['bantuan'], $contentMeta['bantuan']);
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
            $url = is_array($item[$urlKey] ?? null) ? ($item[$urlKey][0] ?? '#') : ($item[$urlKey] ?? '#');

            return [
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'url' => $url,
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
