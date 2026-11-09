<?php

namespace Paparee\BaleDisnaker\Livewire\Panel;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;

/**
 * Overview panel warga untuk fitur pelatihan. Didaftarkan lewat
 * Panel::registerOverview() sehingga menggantikan overview default tala.
 */
#[Layout('tala::layouts.panel')]
#[Title('Overview')]
class Overview extends Component
{
    public function render()
    {
        $uuid = auth('tala')->user()->uuid;
        $period = Period::active();

        $total = Submission::where('user_uuid', $uuid)->count();

        $processed = Submission::where('user_uuid', $uuid)
            ->where('status', 'AI_Processed')
            ->count();

        return view('bale-disnaker::livewire.panel.overview', [
            'period' => $period,
            'total' => $total,
            'processed' => $processed,
            'pending' => max($total - $processed, 0),
            'current' => $period
                ? Submission::with('cluster')
                    ->where('period_id', $period->id)
                    ->where('user_uuid', $uuid)
                    ->first()
                : null,
        ]);
    }
}
