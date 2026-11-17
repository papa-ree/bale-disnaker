<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Program;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Paparee\BaleDisnaker\Models\Program;

#[Layout('bale-disnaker::layouts.app')]
class ProgramList extends Component
{
    public function render(): View
    {
        return view('bale-disnaker::livewire.landing-page.program.program-list', [
            'programs' => $this->programs(),
        ]);
    }

    private function programs(): array
    {
        return Program::query()
            ->published()
            ->with('cluster:id,name')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->orderBy('name')
            ->get(['id', 'name', 'quarter', 'year', 'cluster_id'])
            ->map(fn (Program $program) => [
                'name' => ucfirst($program->name),
                'quarter' => $program->quarter,
                'year' => $program->year,
                'cluster' => $program->cluster?->name,
            ])->all();
    }
}
