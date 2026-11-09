<?php

namespace Paparee\BaleDisnaker\Livewire\Pelatihan;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;

#[Layout('bale-disnaker::layouts.app')]
#[Title('Pelatihan')]
class Index extends Component
{
    public function mount(): void
    {
        // Sudah mengirim di periode aktif: tidak perlu mengisi formulir lagi.
        $user = auth('tala')->user();
        $period = Period::active();

        if ($user && $period && Submission::where('period_id', $period->id)->where('user_uuid', $user->uuid)->exists()) {
            $this->redirect(route('tala.panel.disnaker.status'), navigate: true);
        }
    }

    public function render()
    {
        return view('bale-disnaker::livewire.pelatihan.index', [
            'period' => Period::active(),
        ]);
    }
}
