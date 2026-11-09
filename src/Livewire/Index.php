<?php

namespace Paparee\BaleDisnaker\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('bale-disnaker::layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('bale-disnaker::livewire.index');
    }
}
