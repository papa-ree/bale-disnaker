<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\Computed;

class Hero extends UmpakComponent
{
    public string $slug = 'hero-section';

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

    /**
     * Parse items (array-wrapped values) into stats.
     * Uses meta.order[0] as label key and meta.order[1] as value key.
     * Each item: { "nama_stat": ["job posted"], "nilai": ["500+"] }
     * Returns: [ ["label" => "job posted", "value" => "500+"], ... ]
     */
    #[Computed]
    public function stats(): array
    {
        $section = $this->sectionData;

        if (!$section) {
            return [];
        }

        $order    = $section->meta('order', []);
        $labelKey = $order[0] ?? 'nama_stat';
        $valueKey = $order[1] ?? 'nilai';

        $stats = [];
        foreach ($section->items as $item) {
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

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.hero');
    }
}
