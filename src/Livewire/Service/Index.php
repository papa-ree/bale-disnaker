<?php

namespace Paparee\BaleDisnaker\Livewire\Service;

use Bale\Emperan\Models\Section;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('bale-disnaker::layouts.app')]
class Index extends Component
{
    public function render()
    {
        $section = Section::where('slug', 'service-section')->first();
        $colors = ["#008080", "#20B2AA", "#4169E1", "#3CB371", "#2E8B57", "#5F9EA0"];

        $services = [];
        $meta = [
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

        if ($section && isset($section->content)) {
            $content = $section->content;

            if (isset($content['meta'])) {
                $contentMeta = $content['meta'];
                $meta = array_merge($meta, $contentMeta);

                if (isset($contentMeta['custom']) && is_array($contentMeta['custom'])) {
                    $meta['custom'] = array_merge($meta['custom'], $contentMeta['custom']);
                }

                if (isset($contentMeta['buttons'])) {
                    $meta['buttons'] = $contentMeta['buttons'];
                }
            }

            if (isset($content['items']) && is_array($content['items'])) {
                $rawItems = collect($content['items']);

                $services = $rawItems->map(function ($item, $index) use ($colors) {
                    return [
                        'title' => $item['judul'][0] ?? '',
                        'description' => $item['deskripsi'][0] ?? '',
                        'icon' => $item['icon'][0] ?? 'circle',
                        'url' => $item['url'][0] ?? '#',
                        'color' => $colors[$index % count($colors)]
                    ];
                });

                // Filter out items where title is 'lainnya'
                $services = $services->filter(fn($item) => strtolower($item['title']) !== 'lainnya');
            }
        }

        return view('bale-disnaker::livewire.service.index', [
            'services' => $services,
            'meta' => $meta
        ]);
    }
}
