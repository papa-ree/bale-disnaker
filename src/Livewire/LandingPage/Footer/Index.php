<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Footer;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Bale\Emperan\Models\Section;

class Index extends Component
{
    public string $slug = 'footer-section';
    public array $footer = [];
    public array $about = [];
    public $actived;

    public function mount(?string $slug = null)
    {
        if ($slug) {
            $this->slug = $slug;
        }

        $footerModel = Section::whereSlug($this->slug)->first();
        $aboutModel = Section::whereSlug('hero-section')->first();

        $this->footer = $footerModel?->content ?? [];
        $this->about = $aboutModel?->content ?? [];
        $this->actived = $footerModel?->actived ?? false;
    }

    #[Computed]
    public function meta()
    {
        return $this->footer['meta'] ?? [];
    }

    /**
     * Parse items into grouped links.
     * Items have: grup["..."], nama["..."], url["..."]
     */
    #[Computed]
    public function groupedLinks()
    {
        $items = $this->footer['items'] ?? [];
        $links = [];

        foreach ($items as $item) {
            $grup = is_array($item['grup'] ?? null) ? ($item['grup'][0] ?? 'Lainnya') : ($item['grup'] ?? 'Lainnya');
            $nama = is_array($item['nama'] ?? null) ? ($item['nama'][0] ?? '') : ($item['nama'] ?? '');
            $url = is_array($item['url'] ?? null) ? ($item['url'][0] ?? '#') : ($item['url'] ?? '#');

            if (!empty($nama)) {
                $links[strtolower($grup)][] = [
                    'label' => $nama,
                    'url' => $url
                ];
            }
        }

        return $links;
    }

    #[Computed]
    public function socials()
    {
        $socialLinks = $this->groupedLinks['social'] ?? [];
        $socialConfig = config('landing-page.social-media', []);

        return collect($socialLinks)->map(function ($link) use ($socialConfig) {
            $key = strtolower($link['label']);
            $cfg = $socialConfig[$key] ?? null;
            return [
                'url' => $link['url'],
                'icon' => $cfg['icon'] ?? null,
                'name' => $cfg['name'] ?? ucfirst($key),
                'key' => $key
            ];
        })->toArray();
    }

    #[Computed]
    public function contact()
    {
        $contactLinks = $this->groupedLinks['contact'] ?? [];
        $contact = [];

        foreach ($contactLinks as $link) {
            $type = strtolower($link['label']);
            $value = $link['url'];

            if ($type === 'email')
                $contact['email'] = $value;
            elseif ($type === 'alamat' || $type === 'address')
                $contact['address'] = $value;
            elseif ($type === 'telpon' || $type === 'phone')
                $contact['phone'] = $value;
            else
                $contact[$type] = $value;
        }

        return $contact;
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.footer.index');
    }
}
