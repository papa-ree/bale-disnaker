<?php

namespace Paparee\BaleDisnaker\Livewire;

use Livewire\Component;
use Livewire\Attributes\{Layout};

#[Layout('bale-disnaker::layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('bale-disnaker::livewire.index');
    }
}