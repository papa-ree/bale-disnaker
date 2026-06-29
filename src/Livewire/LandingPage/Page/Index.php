<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Page;

use Bale\Umpak\DTOs\PageData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\{Computed, Layout};

#[Layout('bale-disnaker::layouts.app')]
class Index extends UmpakComponent
{
    public string $pageSlug;

    public function mount(string $page): void
    {
        $this->pageSlug = $page;
    }

    #[Computed]
    public function pageData(): ?PageData
    {
        $found = $this->page($this->pageSlug);

        if (!$found) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return $found;
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.page.index', [
            'page' => $this->pageData,
        ])->layout('bale-disnaker::layouts.app', [
            'title'    => $this->pageData?->title,
            'seoModel' => $this->pageData?->seo,
        ]);
    }
}