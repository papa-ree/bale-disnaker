<?php

namespace Paparee\BaleDisnaker\Livewire\Panel;

use Bale\Tala\Attributes\PanelPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;

#[PanelPage(label: 'Status', icon: 'clipboard-list', order: 10)]
#[Layout('tala::layouts.panel')]
#[Title('Status')]
class Status extends Component
{
    public function render()
    {
        $user = auth('tala')->user();
        $period = Period::active();

        $submission = $period
            ? Submission::with('cluster')->where('period_id', $period->id)->where('user_uuid', $user->uuid)->first()
            : null;

        return view('bale-disnaker::livewire.panel.status', [
            'period' => $period,
            'submission' => $submission,
        ]);
    }
}
