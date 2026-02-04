<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Post;

use Livewire\Component;
use Livewire\Attributes\{Layout, Computed};
use Bale\Emperan\Models\Post;

#[Layout('bale-disnaker::layouts.app')]
class Show extends Component
{
    public $post;

    public function mount(string $post)
    {
        $this->post = Post::whereSlug($post)
            ->wherePublished(true)
            ->first();

        if (!$this->post) {
            abort(404, 'Berita tidak ditemukan');
        }
    }

    #[Computed]
    public function suggestedPosts()
    {
        return Post::wherePublished(true)
            ->where('id', '!=', $this->post->id)
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.post.show');
    }
}
