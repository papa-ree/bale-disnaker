<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Post;

use Bale\Umpak\DTOs\PostData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\{Computed, Layout};

#[Layout('bale-disnaker::layouts.app')]
class Show extends UmpakComponent
{
    public string $postSlug;

    public function mount(string $post): void
    {
        $this->postSlug = $post;
    }

    #[Computed]
    public function postData(): ?PostData
    {
        $found = $this->post($this->postSlug);

        if (!$found) {
            abort(404, 'Berita tidak ditemukan');
        }

        return $found;
    }

    #[Computed]
    public function suggestedPosts()
    {
        return $this->getRandomPosts(5);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.post.show')
            ->layout('bale-disnaker::layouts.app', [
                'title'    => $this->postData?->title,
                'seoModel' => $this->postData?->seo,
            ]);
    }
}
