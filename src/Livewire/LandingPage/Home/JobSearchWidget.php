<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class JobSearchWidget extends UmpakComponent
{
    public string $slug = 'job-widget-section';
    public string $keyword = '';

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
     * Ambil statistik dinamis dari database loker.
     * Tabel loker bukan domain umpak, jadi DB::table() tetap digunakan.
     */
    #[Computed]
    public function stats(): array
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
     * Ambil kategori populer dari tabel loker.
     */
    #[Computed]
    public function categories(): array
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

    public function search(): void
    {
        $this->redirectRoute('bale.jobs', ['search' => $this->keyword ?: ''], navigate: true);
    }

    public function searchCategory(string $category): void
    {
        $this->redirectRoute('bale.jobs', ['category' => $category], navigate: true);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.job-search-widget');
    }
}
