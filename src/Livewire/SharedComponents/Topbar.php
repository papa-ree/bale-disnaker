<?php

namespace Paparee\BaleDisnaker\Livewire\SharedComponents;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Navigation;

class Topbar extends Component
{
    public function render()
    {
        return view('bale-disnaker::livewire.shared-components.topbar');
    }

    #[Computed]
    public function availableNavs()
    {
        return Navigation::with('children')->whereNull('parent_id')->whereActived(true)->orderBy('order')->get();
    }
}
