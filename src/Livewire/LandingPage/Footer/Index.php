<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Footer;

use Bale\Umpak\DTOs\SectionData;
use Bale\Umpak\Livewire\UmpakComponent;
use Livewire\Attributes\Computed;

class Index extends UmpakComponent
{
    public string $slug = 'footer-section';

    public function mount(?string $slug = null): void
    {
        if ($slug) {
            $this->slug = $slug;
        }
    }

    #[Computed]
    public function footerSection(): ?SectionData
    {
        return $this->section($this->slug);
    }

    #[Computed]
    public function heroSection(): ?SectionData
    {
        return $this->section('hero-section');
    }

    #[Computed]
    public function meta(): array
    {
        return $this->footerSection?->meta ?? [];
    }

    /**
     * Parse items into grouped links.
     * Items have: grup["..."], nama["..."], url["..."]
     */
    #[Computed]
    public function groupedLinks(): array
    {
        $items = $this->footerSection?->items ?? [];
        $links = [];

        foreach ($items as $item) {
            $grup   = is_array($item['grup'] ?? null) ? ($item['grup'][0] ?? 'Lainnya') : ($item['grup'] ?? 'Lainnya');
            $nama   = is_array($item['nama'] ?? null) ? ($item['nama'][0] ?? '') : ($item['nama'] ?? '');
            $rawUrl = is_array($item['url'] ?? null) ? ($item['url'][0] ?? '#') : ($item['url'] ?? '#');
            $url    = self::safeUrl($rawUrl);

            if (!empty($nama)) {
                $links[strtolower($grup)][] = [
                    'label' => $nama,
                    'url'   => $url,
                ];
            }
        }

        return $links;
    }

    #[Computed]
    public function socials(): array
    {
        $socialLinks  = $this->groupedLinks['social'] ?? [];
        $socialConfig = config('umpak.social-media', []);

        return collect($socialLinks)->map(function ($link) use ($socialConfig) {
            $key = strtolower($link['label']);
            $cfg = $socialConfig[$key] ?? null;
            return [
                'url'  => $link['url'],
                'icon' => $cfg['icon'] ?? null,
                'name' => $cfg['name'] ?? ucfirst($key),
                'key'  => $key,
            ];
        })->toArray();
    }

    #[Computed]
    public function contact(): array
    {
        $contactLinks = $this->groupedLinks['contact'] ?? [];
        $contact      = [];

        foreach ($contactLinks as $link) {
            $type  = strtolower($link['label']);
            $value = $link['url'];

            if ($type === 'email') {
                $contact['email'] = $value;
            } elseif ($type === 'alamat' || $type === 'address') {
                $contact['address'] = $value;
            } elseif ($type === 'telpon' || $type === 'phone') {
                $contact['phone'] = $value;
            } else {
                $contact[$type] = $value;
            }
        }

        return $contact;
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.footer.index');
    }
}
