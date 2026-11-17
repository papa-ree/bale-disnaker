<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\Livewire\UmpakComponent;
use Paparee\BaleDisnaker\Models\Program;

/**
 * Program pelatihan yang sudah ditetapkan Dinas Tenaga Kerja.
 *
 * Sumbernya klaster yang disetujui, tetapi hanya sebagian yang menjadi program —
 * karena itu section ini ditampilkan terpisah dari daftar usulan.
 * Section disembunyikan bila `program-section` belum ada di CMS.
 */
class ProgramSection extends UmpakComponent
{
    public string $slug = 'program-section';

    public function mount(?string $slug = null): void
    {
        if ($slug) {
            $this->slug = $slug;
        }
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.program-section', [
            'section' => $this->section($this->slug),
            'programs' => $this->programs(),
        ]);
    }

    private function programs(): array
    {
        return Program::query()
            ->published()
            ->with('cluster:id,name')
            ->orderByDesc('published_at')
            ->limit(4)
            ->get(['id', 'name', 'quarter', 'year', 'cluster_id'])
            ->map(fn (Program $program) => [
                'name' => ucfirst($program->name),
                'quarter' => $program->quarter,
                'year' => $program->year,
                'cluster' => $program->cluster?->name,
            ])->all();
    }
}
