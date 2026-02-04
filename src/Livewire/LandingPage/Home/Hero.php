<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;

use Bale\Emperan\Models\Section;

class Hero extends Component
{
    public array $section = [];

    public function mount()
    {
        $data = Section::whereSlug('hero-disnaker-section')->first();

        $this->section = $data ? $data->toArray() : [];
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.hero');
    }
}
