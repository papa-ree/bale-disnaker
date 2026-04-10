<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;

class Hero extends Component
{
    public string $slug = 'hero-section';
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

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.hero');
    }

    #[Computed]
    public function meta()
    {
        $meta = $this->section['meta'] ?? [];

        if (isset($meta['buttons']) && is_array($meta['buttons'])) {
            $meta['buttons'] = collect($meta['buttons'])->map(function ($button) {
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
    public function items()
    {
        return $this->section['items'] ?? [];
    }

    /**
     * Parse items (array-wrapped values) into stats.
     * Uses meta.order[0] as label key and meta.order[1] as value key.
     * Each item: { "nama_stat": ["job posted"], "nilai": ["500+"] }
     * Returns: [ ["label" => "job posted", "value" => "500+"], ... ]
     */
    #[Computed]
    public function stats()
    {
        $items = $this->items;
        $meta = $this->meta;
        $order = $meta['order'] ?? [];
        $labelKey = $order[0] ?? 'nama_stat';
        $valueKey = $order[1] ?? 'nilai';

        $stats = [];
        foreach ($items as $item) {
            $label = is_array($item[$labelKey] ?? null)
                ? ($item[$labelKey][0] ?? null)
                : ($item[$labelKey] ?? null);

            $value = is_array($item[$valueKey] ?? null)
                ? ($item[$valueKey][0] ?? null)
                : ($item[$valueKey] ?? null);

            if ($label !== null && $value !== null) {
                $stats[] = ['label' => $label, 'value' => $value];
            }
        }

        return $stats;
    }
}
