<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Job;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Bale\Emperan\Models\Section;

#[Layout('bale-disnaker::layouts.app')]
class JobList extends Component
{
    #[Url(as: 'search')]
    public $searchQuery = '';

    public $selectedType = 'All';

    #[Url(as: 'category')]
    public $selectedCategory = 'All';

    public function getSectionProperty()
    {
        return Section::whereSlug('job-vacancies-section')->first();
    }

    public function getJobsDataProperty()
    {
        if (!$this->section) {
            return [];
        }

        $items = $this->section->content['items'] ?? [];

        if (isset($items['jobs'])) {
            return $items['jobs'];
        }

        if (isset($items['data'])) {
            return $items['data'];
        }

        // Check if items itself is a list of jobs (numeric keys)
        if (array_is_list($items) && !empty($items)) {
            return collect($items)->map(function ($item) {
                return [
                    'id' => $item['id'][0] ?? uniqid(),
                    'title' => $item['nama pekerjaan'][0] ?? 'Untitled',
                    'company' => $item['nama perusahaan'][0] ?? 'Unknown Company',
                    'location' => $item['lokasi'][0] ?? 'Ponorogo',
                    'type' => $item['tipe'][0] ?? 'Full-time',
                    'category' => $item['kategori'][0] ?? 'General',
                    'salary' => $item['gaji'][0] ?? 'Negotiable',
                    'description' => $item['deskripsi perusahaan'][0] ?? '',
                    'requirements' => isset($item['kualifikasi'][0]) ? $item['kualifikasi'][0] : '',
                    'postedDate' => $item['updated_at'][0],
                ];
            })->toArray();
        }

        return [];
    }

    public function getJobTypesProperty()
    {
        $types = collect($this->jobsData)->pluck('type')->unique()->values()->toArray();
        return array_merge(['All'], $types);
    }

    public function getCategoriesProperty()
    {
        $categories = collect($this->jobsData)->pluck('category')->unique()->values()->toArray();
        return array_merge(['All'], $categories);
    }

    public function getFilteredJobsProperty()
    {
        return collect($this->jobsData)->filter(function ($job) {
            $query = strtolower($this->searchQuery);
            if ($query === 'all') {
                $query = '';
            }

            $matchesSearch = $query === '' ||
                str_contains(strtolower($job['title']), $query) ||
                str_contains(strtolower($job['company']), $query) ||
                str_contains(strtolower($job['description']), $query);

            $matchesType = $this->selectedType === 'All' || $job['type'] === $this->selectedType;
            $matchesCategory = $this->selectedCategory === 'All' || $job['category'] === $this->selectedCategory;

            return $matchesSearch && $matchesType && $matchesCategory;
        });
    }

    public function clearFilters()
    {
        $this->searchQuery = '';
        $this->selectedType = 'All';
        $this->selectedCategory = 'All';
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.job.job-list', [
            'jobs' => $this->filteredJobs,
            'jobTypes' => $this->jobTypes,
            'categories' => $this->categories,
            'meta' => $this->section->content['meta'] ?? []
        ]);
    }
}
