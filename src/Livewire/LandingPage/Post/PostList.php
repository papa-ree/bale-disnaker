<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Post;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\{Computed, Layout, Url};

#[Layout('bale-disnaker::layouts.app')]
class PostList extends UmpakComponent
{
    public int $amount = 6;

    #[Computed]
    public function sectionData(): ?SectionData
    {
        return $this->section('post-disnaker-section');
    }

    #[Url]
    public string $search = '';

    #[Url]
    public string $date = '';

    public function updated(string $property): void
    {
        // Reset amount when search or date filter changes
        if (in_array($property, ['search', 'date'])) {
            $this->amount = 6;
        }
    }

    public function loadMore(): void
    {
        $this->amount += 6;
    }

    public function clearSearch(): void
    {
        $this->search = '';
    }

    #[Computed]
    public function posts()
    {
        return $this->searchPosts($this->amount, $this->search, $this->date);
    }

    #[Computed]
    public function hasMore(): bool
    {
        return $this->countSearchPosts($this->search, $this->date) > $this->amount;
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.post.post-list');
    }
}
