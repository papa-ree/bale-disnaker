<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;

class JobSearchWidget extends Component
{
    public string $slug = 'job-widget-section';
    public $keyword = '';
    public array $section = [];
    public $actived;

    public function mount(?string $slug = null)
    {
        if ($slug) {
            $this->slug = $slug;
        }

        $data = Section::whereSlug($this->slug)->first();

        $this->section = $data ? $data->content : [];
        $this->actived = $data ? $data->actived : false;
    }

    #[Computed]
    public function meta()
    {
        return $this->section['meta'] ?? [];
    }

    /**
     * Parse items (array-wrapped values) into stats.
     * Uses keys 'nilai' and 'nama stat' as seen in the database output.
     */
    #[Computed]
    public function stats()
    {
        $items = $this->section['items'] ?? [];
        $stats = [];

        foreach ($items as $item) {
            $label = is_array($item['nama stat'] ?? null)
                ? ($item['nama stat'][0] ?? null)
                : ($item['nama stat'] ?? null);

            $value = is_array($item['nilai'] ?? null)
                ? ($item['nilai'][0] ?? null)
                : ($item['nilai'] ?? null);

            if ($label !== null && $value !== null) {
                $stats[] = [
                    'label' => $label,
                    'value' => $value
                ];
            }
        }

        return $stats;
    }

    /**
     * Fetch categories for popular searches. 
     * Usually extracted from job-vacancies-section or similar.
     */
    #[Computed]
    public function categories()
    {
        // Try to fetch from job-vacancies-section as categories usually live there
        $vacancies = Section::whereSlug('job-vacancies-section')->first();

        if ($vacancies && isset($vacancies->content['items'])) {
            $items = $vacancies->content['items'];

            // Handle if items is nested
            $jobs = $items['jobs'] ?? ($items['data'] ?? $items);

            if (is_array($jobs)) {
                return collect($jobs)
                    ->pluck('kategori') // or 'category' if mapped differently
                    ->flatten()
                    ->filter()
                    ->unique()
                    ->values()
                    ->take(5)
                    ->toArray();
            }
        }

        return [];
    }

    public function search()
    {
        return $this->redirectRoute('bale.jobs', ['search' => $this->keyword ?: 'all'], navigate: true);
    }

    public function searchCategory($category)
    {
        return $this->redirectRoute('bale.jobs', ['category' => $category], navigate: true);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.job-search-widget');
    }
}
