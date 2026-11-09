<?php

namespace Paparee\BaleDisnaker\Livewire\Panel;

use Bale\Tala\Attributes\PanelPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Paparee\BaleDisnaker\Models\Submission;

#[PanelPage(label: 'Riwayat', icon: 'history', order: 20)]
#[Layout('tala::layouts.panel')]
#[Title('Riwayat')]
class Riwayat extends Component
{
    use WithPagination;

    public function render()
    {
        return view('bale-disnaker::livewire.panel.riwayat', [
            'submissions' => Submission::with(['period', 'cluster'])
                ->where('user_uuid', auth('tala')->user()->uuid)
                ->latest('created_at')
                ->paginate(10),
        ]);
    }
}
