<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Job;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

#[Layout('bale-disnaker::layouts.app')]
class JobList extends Component
{
    use WithPagination;

    #[Url(as: 'search')]
    public string $searchQuery = '';

    #[Url(as: 'type')]
    public string $selectedType = 'All';

    #[Url(as: 'category')]
    public string $selectedCategory = 'All';

    /**
     * Reset pagination setiap kali filter berubah.
     */
    public function updatingSearchQuery(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedType(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory(): void
    {
        $this->resetPage();
    }

    /**
     * Daftar tipe pekerjaan unik dari tabel loker.
     */
    public function getJobTypesProperty(): array
    {
        $types = DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->distinct()
            ->orderBy('tipe')
            ->pluck('tipe')
            ->filter()
            ->values()
            ->toArray();

        return array_merge(['All'], $types);
    }

    /**
     * Daftar kategori unik dari tabel loker.
     */
    public function getCategoriesProperty(): array
    {
        $categories = DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->distinct()
            ->orderBy('kategory')
            ->pluck('kategory')
            ->filter()
            ->values()
            ->toArray();

        return array_merge(['All'], $categories);
    }

    /**
     * Query utama ke tabel loker dengan filter dan paginate.
     */
    public function getFilteredJobsProperty()
    {
        $query = DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if (!empty($this->searchQuery)) {
            $search = $this->searchQuery;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pekerjaan', 'like', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$search}%");
            });
        }

        // Filter tipe
        if ($this->selectedType !== 'All') {
            $query->where('tipe', $this->selectedType);
        }

        // Filter kategori
        if ($this->selectedCategory !== 'All') {
            $query->where('kategory', $this->selectedCategory);
        }

        return $query->paginate(20);
    }

    public function clearFilters(): void
    {
        $this->searchQuery = '';
        $this->selectedType = 'All';
        $this->selectedCategory = 'All';
        $this->resetPage();
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.job.job-list', [
            'jobs'       => $this->filteredJobs,
            'jobTypes'   => $this->jobTypes,
            'categories' => $this->categories,
            'meta'       => [],
        ]);
    }
}
