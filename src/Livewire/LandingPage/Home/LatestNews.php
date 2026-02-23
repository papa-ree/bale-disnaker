<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;
use Bale\Emperan\Models\Post;

class LatestNews extends Component
{
    public string $slug = 'post-section';
    public array $section = [];
    public $actived;

    public function mount(?string $slug = null)
    {
        if ($slug) {
            $this->slug = $slug;
        }

        $sectionModel = Section::whereSlug($this->slug)->first();

        $this->section = $sectionModel?->content ?? [];
        $this->actived = $sectionModel?->actived ?? false;
    }

    #[Computed]
    public function meta()
    {
        return $this->section['meta'] ?? [];
    }

    #[Computed]
    public function availablePosts()
    {
        $limit = $this->meta['grid'] ?? 3;

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
