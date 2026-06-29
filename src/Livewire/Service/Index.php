<?php

namespace Paparee\BaleDisnaker\Livewire\Service;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\{Computed, Layout};

#[Layout('bale-disnaker::layouts.app')]
class Index extends UmpakComponent
{
    #[Computed]
    public function sectionData(): ?SectionData
    {
        return $this->section('service-section');
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

        if (isset($contentMeta['custom']) && is_array($contentMeta['custom'])) {
            $meta['custom'] = array_merge($defaultMeta['custom'], $contentMeta['custom']);
        }

        if (isset($contentMeta['buttons']) && is_array($contentMeta['buttons'])) {
            $meta['buttons'] = $contentMeta['buttons'];
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

        $colors = ['#008080', '#20B2AA', '#4169E1', '#3CB371', '#2E8B57', '#5F9EA0'];

        $services = collect($section->items)->map(function ($item, $index) use ($colors) {
            return [
                'title'       => $item['judul'][0]  ?? ($item['judul']  ?? ''),
                'description' => $item['deskripsi'][0] ?? ($item['deskripsi'] ?? ''),
                'icon'        => $item['icon'][0]   ?? ($item['icon']   ?? 'circle'),
                'url'         => $item['url'][0]    ?? ($item['url']    ?? '#'),
                'color'       => $colors[$index % count($colors)],
            ];
        });

        // Filter out "lainnya" items
        return $services->filter(fn ($item) => strtolower($item['title']) !== 'lainnya')->values();
    }

    public function render()
    {
        return view('bale-disnaker::livewire.service.index', [
            'services' => $this->services,
            'meta'     => $this->meta,
        ]);
    }
}
