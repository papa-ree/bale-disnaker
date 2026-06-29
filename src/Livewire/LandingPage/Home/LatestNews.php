<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\Computed;

class LatestNews extends UmpakComponent
{
    public string $slug = 'post-section';

    public function mount(?string $slug = null): void
    {
        if ($slug) {
            $this->slug = $slug;
        }
    }

    #[Computed]
    public function sectionData(): ?SectionData
    {
        return $this->section($this->slug);
    }

    #[Computed]
    public function posts()
    {
        $limit = (int) ($this->sectionData?->meta('grid', 3) ?? 3);
        $limit = $limit > 0 ? $limit : 3;

        return $this->latestPosts($limit);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.latest-news', [
            'posts' => $this->posts,
        ]);
    }
}
