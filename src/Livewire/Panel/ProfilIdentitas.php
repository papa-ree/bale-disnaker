<?php

namespace Paparee\BaleDisnaker\Livewire\Panel;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Paparee\BaleDisnaker\Models\CitizenProfile;
use Paparee\BaleDisnaker\Support\DataCrypto;

/**
 * Blok identitas warga untuk halaman Profil milik bale/tala. Didaftarkan lewat
 * Panel::registerProfileSection() supaya tala tidak perlu tahu tabel pelatihan.
 */
class ProfilIdentitas extends Component
{
    #[Locked]
    public ?string $nik = null;

    #[Locked]
    public ?string $whatsapp = null;

    public function mount(): void
    {
        $profile = CitizenProfile::where('user_uuid', auth('tala')->user()->uuid)->first();

        // Cast model sudah mendekripsi; jangan dekripsi dua kali.
        $this->nik = DataCrypto::mask($profile?->nik);
        $this->whatsapp = DataCrypto::mask($profile?->whatsapp);
    }

    public function render()
    {
        return view('bale-disnaker::livewire.panel.profil-identitas');
    }
}
