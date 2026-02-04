<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Page;

use Bale\Emperan\Models\Page;
use Livewire\Component;
use Livewire\Attributes\{Layout};

#[Layout('bale-disnaker::layouts.app')]
class Index extends Component
{
    public $page;

    public function mount(string $page)
    {
        $this->page = Page::whereSlug($page)->first();

        // Jika halaman tidak ditemukan, redirect atau tampilkan 404
        if (!$this->page) {
            abort(404, 'Halaman tidak ditemukan');
        }
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.page.index', [
            'page' => $this->page
        ]);
    }
}