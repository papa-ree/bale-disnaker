<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\Livewire\UmpakComponent;
use Paparee\BaleDisnaker\Models\Program;

/**
 * Program pelatihan yang sudah ditetapkan Dinas Tenaga Kerja.
 *
 * Sumbernya klaster yang disetujui, tetapi hanya sebagian yang menjadi program —
 * karena itu section ini ditampilkan terpisah dari daftar usulan.
 */
class ProgramSection extends UmpakComponent
{
    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.program-section', [
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
