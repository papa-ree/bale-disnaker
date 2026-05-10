<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Job;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('bale-disnaker::layouts.app')]
class JobDetail extends Component
{
    public string $slug;
    public ?object $job = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->job  = $this->getJob($slug);

        if (!$this->job) {
            redirect()->route('bale.jobs');
        }
    }

    protected function getJob(string $slug): ?object
    {
        return DB::table('loker')
            ->whereNull('deleted_at')
            ->where('actived', 1)
            ->where('slug', $slug)
            ->first();
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.job.job-detail');
    }
}
