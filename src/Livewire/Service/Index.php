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

        if ($section && isset($section->content)) {
            $content = $section->content;

            if (isset($content['meta'])) {
                $meta['title'] = $content['meta']['title'] ?? $meta['title'];
                $meta['subtitle'] = $content['meta']['subtitle'] ?? $meta['subtitle'];
                if (isset($content['meta']['bantuan'])) {
                    $meta['bantuan'] = array_merge($meta['bantuan'], $content['meta']['bantuan']);
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
