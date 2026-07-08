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
     *
     * Items have: grup["..."], nama["..."], url["..."]
     *
     * Untuk grup "contact", nilai url disimpan sebagai rawValue tanpa
     * dilewatkan safeUrl() karena field tersebut berisi nilai teks
     * (alamat, email, telepon) bukan URL navigasi.
     */
    #[Computed]
    public function groupedLinks(): array
    {
        $items = $this->footerSection?->items ?? [];
        $links = [];

        foreach ($items as $item) {
            $grup     = is_array($item['grup'] ?? null) ? ($item['grup'][0] ?? 'Lainnya') : ($item['grup'] ?? 'Lainnya');
            $nama     = is_array($item['nama'] ?? null) ? ($item['nama'][0] ?? '') : ($item['nama'] ?? '');
            $rawValue = is_array($item['url']  ?? null) ? ($item['url'][0]  ?? '')  : ($item['url']  ?? '');
            $grupKey  = strtolower($grup);

            if (empty($nama)) {
                continue;
            }

            // Grup "contact" menyimpan nilai teks (bukan URL) → tidak di-safeUrl
            if ($grupKey === 'contact') {
                $links[$grupKey][] = [
                    'label'    => $nama,
                    'rawValue' => trim($rawValue),
                ];
            } elseif ($grupKey === 'social') {
                // Untuk social media, pastikan ditambahkan https:// jika tidak mempunyai scheme (misal instagram.com)
                $url = trim($rawValue);
                if (!empty($url) && $url !== '#') {
                    if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                        $url = 'https://' . $url;
                    }
                }
                $links[$grupKey][] = [
                    'label' => $nama,
                    'url'   => self::safeUrl($url ?: '#'),
                ];
            } else {
                $links[$grupKey][] = [
                    'label' => $nama,
                    'url'   => self::safeUrl($rawValue ?: '#'),
                ];
            }
        }

        return $links;
    }

    /**
     * Social media links dengan icon & name dari config('umpak.social-media').
     *
     * Iterasi dari config sebagai sumber kebenaran — hanya tampilkan platform
     * yang ada item-nya di CMS (label cocok dengan key config).
     */
    #[Computed]
    public function socials(): array
    {
        $socialItems  = $this->groupedLinks['social'] ?? [];
        $socialConfig = config('umpak.social-media', []);

        // Buat lookup: key (instagram) → url dari CMS
        $urlByKey = [];
        foreach ($socialItems as $link) {
            $key = strtolower($link['label']);
            if (!empty($link['url']) && $link['url'] !== '#') {
                $urlByKey[$key] = $link['url'];
            }
        }

        // Iterasi config sebagai master — ambil hanya yang ada URL-nya
        $result = [];
        foreach ($socialConfig as $key => $platform) {
            if (isset($urlByKey[$key])) {
                $result[] = [
                    'key'  => $key,
                    'url'  => $urlByKey[$key],
                    'icon' => $platform['icon'],   // SVG dari config, bukan DB
                    'name' => $platform['name'],
                ];
            }
        }

        return $result;
    }

    /**
     * Kontak dari items grup "contact".
     * Membaca rawValue (bukan url) agar nilai email/telepon/alamat tidak terdistorsi.
     */
    #[Computed]
    public function contact(): array
    {
        $contactLinks = $this->groupedLinks['contact'] ?? [];
        $contact      = [];

        foreach ($contactLinks as $link) {
            $type  = strtolower($link['label']);
            $value = $link['rawValue'] ?? '';

            if (empty($value)) {
                continue;
            }

            if ($type === 'email') {
                $contact['email'] = $value;
            } elseif ($type === 'alamat' || $type === 'address') {
                $contact['address'] = $value;
            } elseif ($type === 'telepon' || $type === 'telpon' || $type === 'phone') {
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
