<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Footer;

use Livewire\Component;

use Bale\Emperan\Models\Section;

class Index extends Component
{
    public function render()
    {
        $aboutSection = Section::whereSlug('hero-disnaker-section')->first();
        $footerSection = Section::whereSlug('footer-disnaker-section')->first();

        $footerData = $footerSection?->content ?? [];

        // Sort "Layanan Kami" to keep "Lainnya" at the end
        if (!empty($footerData['meta']['layanan kami']) && is_array($footerData['meta']['layanan kami'])) {
            $services = $footerData['meta']['layanan kami'];
            $others = [];

            foreach ($services as $key => $value) {
                if (strtolower($key) === 'lainnya') {
                    $others[$key] = $value;
                    unset($services[$key]);
                }
            }

            $footerData['meta']['layanan kami'] = array_merge($services, $others);
        }

        return view('bale-disnaker::livewire.landing-page.footer.index', [
            'about' => $aboutSection?->content ?? [],
            'footer' => $footerData
        ]);
    }
}
