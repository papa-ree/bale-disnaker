<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Post;

use Livewire\Component;
use Livewire\Attributes\{Computed, Layout, Url};
use Bale\Emperan\Models\Post;
use Bale\Emperan\Models\Section;

#[Layout('bale-disnaker::layouts.app')]
class PostList extends Component
{
    public array $section = [];
    public int $amount = 6;

    public function mount()
    {
        $data = Section::whereSlug('post-disnaker-section')->first();
        $this->section = $data ? $data->toArray() : [];
    }

    #[Url]
    public string $search = '';

    #[Url]
    public string $date = '';

    public function updated($property)
    {
        // Reset amount when search or date filter changes
        if (in_array($property, ['search', 'date'])) {
            $this->amount = 6;
        }
    }

    public function loadMore()
    {
        $this->amount += 6;
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    #[Computed]
    public function posts()
    {
        $query = Post::query()->wherePublished(true);

        // Filter by search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by date
        if ($this->date) {
            if (str_contains($this->date, ' to ')) {
                // Range date
                [$start, $end] = explode(' to ', $this->date);
                $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            } else {
                // Single date
                $query->whereDate('created_at', $this->date);
            }
        }

        return $query->latest()->take($this->amount)->get();
    }

    #[Computed]
    public function hasMore()
    {
        $query = Post::query()->wherePublished(true);

        // Apply same filters as posts method
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->date) {
            if (str_contains($this->date, ' to ')) {
                [$start, $end] = explode(' to ', $this->date);
                $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            } else {
                $query->whereDate('created_at', $this->date);
            }
        }

        return $query->count() > $this->amount;
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.post.post-list');
    }
}
