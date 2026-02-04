<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Carbon\Carbon;

use Bale\Emperan\Models\Section;
use Bale\Emperan\Models\Post;
use Livewire\Attributes\Computed;

class LatestNews extends Component
{
    public array $section = [];

    public function mount()
    {
        $data = Section::whereSlug('post-disnaker-section')->first();

        $this->section = $data ? $data->toArray() : [];
    }

    #[Computed]
    public function availablePosts()
    {
        $limit = $this->section['content']['meta']['grid'] ?? 3;

        // Ensure limit is numeric and > 0
        $limit = is_numeric($limit) && $limit > 0 ? (int) $limit : 3;

        return Post::latest()->wherePublished(true)->take($limit)->get();
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.latest-news', [
            'posts' => $this->availablePosts
        ]);
    }
}
