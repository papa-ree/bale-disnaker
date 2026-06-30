<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\Computed;

class ServicesSection extends UmpakComponent
{
    public string $slug = 'service-section';

    public function mount(?string $slug = null): void
    {
        if ($slug) {
            $this->slug = $slug;
        }
    }

    #[Computed]
    public function sectionData(): ?SectionData
    {
        return $this->section($this->slug);
    }

    #[Computed]
    public function meta(): array
    {
        $section = $this->sectionData;

        $defaultMeta = [
            'title'    => 'Layanan Kami',
            'subtitle' => 'Solusi tenaga kerja komprehensif yang dirancang untuk memberdayakan pencari kerja dan pemberi kerja.',
            'custom'   => [
                'columns'           => 3,
                'icon_style'        => 'outline',
                'judul_bantuan'     => 'Butuh bantuan dengan layanan kami?',
                'deskripsi_bantuan' => 'Tim kami siap membantu Anda dengan layanan ketenagakerjaan, program pelatihan, dan solusi tenaga kerja.',
            ],
            'buttons' => [],
        ];

        if (!$section) {
            return $defaultMeta;
        }

        $contentMeta = $section->meta;
        $meta        = array_merge($defaultMeta, $contentMeta);

        // Merge nested custom array agar keys default-nya tetap ada
        if (isset($contentMeta['custom']) && is_array($contentMeta['custom'])) {
            $meta['custom'] = array_merge($defaultMeta['custom'], $contentMeta['custom']);
        }

        // Button URL resolution
        if (isset($contentMeta['buttons']) && is_array($contentMeta['buttons'])) {
            $meta['buttons'] = collect($contentMeta['buttons'])->map(function ($button) {
                $rawUrl     = $button['url'] ?? '#';
                $isExternal = str_starts_with($rawUrl, 'http');
                $button['url']      = self::safeUrl($rawUrl);
                $button['navigate'] = !$isExternal && $button['url'] !== '#' ? 'wire:navigate.hover' : '';
                $button['target']   = $isExternal ? '_blank' : '';
                return $button;
            })->toArray();
        }

        return $meta;
    }

    #[Computed]
    public function services()
    {
        $section = $this->sectionData;

        if (!$section || !$section->hasItems()) {
            return collect();
        }

        $order    = $section->meta('order', ['url', 'icon', 'judul', 'deskripsi']);
        $urlKey   = $order[0] ?? 'url';
        $iconKey  = $order[1] ?? 'icon';
        $titleKey = $order[2] ?? 'judul';
        $descKey  = $order[3] ?? 'deskripsi';

        $colors = ['#008080', '#20B2AA', '#4169E1', '#3CB371', '#2E8B57', '#5F9EA0'];

        $services = collect($section->items)->map(function ($item, $index) use ($colors, $urlKey, $iconKey, $titleKey, $descKey) {
            $title       = is_array($item[$titleKey] ?? null) ? ($item[$titleKey][0] ?? '') : ($item[$titleKey] ?? '');
            $description = is_array($item[$descKey] ?? null) ? ($item[$descKey][0] ?? '') : ($item[$descKey] ?? '');
            $icon        = is_array($item[$iconKey] ?? null) ? ($item[$iconKey][0] ?? 'circle') : ($item[$iconKey] ?? 'circle');
            $rawUrl      = is_array($item[$urlKey] ?? null) ? ($item[$urlKey][0] ?? '#') : ($item[$urlKey] ?? '#');
            $isExternal  = str_starts_with($rawUrl, 'http');
            $url         = self::safeUrl($rawUrl);
            $navigate    = !$isExternal && $url !== '#' ? 'wire:navigate.hover' : '';
            $target      = $isExternal ? '_blank' : '';

            return [
                'title'       => $title,
                'description' => $description,
                'icon'        => $icon,
                'url'         => $url,
                'is_external' => $isExternal,
                'navigate'    => $navigate,
                'target'      => $target,
                'color'       => $colors[$index % count($colors)],
            ];
        });

        // Pastikan "Lainnya" selalu di akhir
        $others       = $services->filter(fn ($item) => strtolower($item['title']) === 'lainnya');
        $mainServices = $services->reject(fn ($item) => strtolower($item['title']) === 'lainnya');

        return $mainServices->concat($others);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.services-section');
    }
}
