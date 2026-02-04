<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Bale\Emperan\Models\Section;

class JobSearchWidget extends Component
{
    public $keyword = '';
    public array $section = [];

    public function mount()
    {
        $data = Section::whereSlug('job-vacancies-section')->first();

        $this->section = $data ? $data->content : [];

        // If 'kategori' doesn't exist in items, try to extract from jobs list
        if (!isset($this->section['items']['kategori']) && !empty($this->section['items'])) {
            $jobs = $this->section['items'];
            // Normalize jobs list
            if (isset($jobs['jobs']))
                $jobs = $jobs['jobs'];
            elseif (isset($jobs['data']))
                $jobs = $jobs['data'];

            if (is_array($jobs)) {
                $categories = collect($jobs)
                    ->pluck('kategori')
                    ->flatten()
                    ->unique()
                    ->values()
                    ->toArray();

                if (!empty($categories)) {
                    $this->section['items']['kategori'] = $categories;
                }
            }
        }
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
