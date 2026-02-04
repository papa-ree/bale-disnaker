<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Job;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Bale\Emperan\Models\Section;

#[Layout('bale-disnaker::layouts.app')]
class JobDetail extends Component
{
    public $jobId;
    public $job;

    public function mount($id)
    {
        $this->jobId = $id;
        $this->job = $this->getJob($id);

        if (!$this->job) {
            return redirect()->route('bale.jobs');
        }
    }

    public function getJob($id)
    {
        $section = Section::whereSlug('job-vacancies-section')->first();
        if (!$section)
            return null;

        $items = $section->content['items'] ?? [];

        // Normalize items
        if (isset($items['jobs']))
            $items = $items['jobs'];
        elseif (isset($items['data']))
            $items = $items['data'];

        if (!is_array($items))
            return null;

        $foundItem = collect($items)->first(function ($item) use ($id) {
            return isset($item['id'][0]) && $item['id'][0] == $id;
        });

        if (!$foundItem)
            return null;

        // Map item to usable format
        return [
            'id' => $foundItem['id'][0] ?? $id,
            'title' => $foundItem['nama pekerjaan'][0] ?? 'Untitled',
            'company' => $foundItem['nama perusahaan'][0] ?? 'Unknown Company',
            'location' => $foundItem['lokasi'][0] ?? 'Ponorogo',
            'type' => $foundItem['tipe'][0] ?? 'Full-time',
            'category' => $foundItem['kategori'][0] ?? 'General',
            'salary' => $foundItem['gaji'][0] ?? 'Negotiable',
            'description' => $foundItem['deskripsi pekerjaan'] ?? [], // Array of descriptions
            'company_description' => $foundItem['deskripsi perusahaan'] ?? [], // Array
            'requirements' => $foundItem['kualifikasi'] ?? [], // Array
            'documents' => $foundItem['persyaratan'] ?? [], // Array
            'apply' => $foundItem['apply'] ?? [], // Array
            'url' => $foundItem['url'][0] ?? '#',
            'posted_at' => $foundItem['created_at'][0] ?? now(),
            'updated_at' => $foundItem['updated_at'][0] ?? now(),
        ];
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.job.job-detail');
    }
}
