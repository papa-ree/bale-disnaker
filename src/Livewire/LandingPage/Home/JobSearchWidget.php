<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
     * Ambil statistik dinamis dari database.
     */
    #[Computed]
    public function stats()
    {
        return [
            [
                'label' => 'Total Lowongan',
                'value' => DB::table('loker')->whereNull('deleted_at')->where('actived', 1)->count(),
            ],
            [
                'label' => 'Perusahaan',
                'value' => DB::table('loker_companies')->whereNull('deleted_at')->where('actived', 1)->count(),
            ],
            [
                'label' => 'Kategori',
                'value' => DB::table('loker_categories')->whereNull('deleted_at')->where('actived', 1)->count(),
            ],
            [
                'label' => 'Tipe Pekerjaan',
                'value' => DB::table('loker_types')->whereNull('deleted_at')->where('actived', 1)->count(),
            ],
        ];
    }

    /**
     * Fetch categories for popular searches. 
     * Usually extracted from job-vacancies-section or similar.
     */
    #[Computed]
    public function categories()
    {
        return DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->distinct()
            ->orderBy('kategory')
            ->pluck('kategory')
            ->filter()
            ->values()
            ->take(5)
            ->toArray();
    }

    /**
     * Ambil 5 lowongan terbaru.
     */
    #[Computed]
    public function latestJobs()
    {
        return DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function search()
    {
        return $this->redirectRoute('bale.jobs', ['search' => $this->keyword ?: ''], navigate: true);
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
