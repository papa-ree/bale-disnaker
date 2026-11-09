<?php

namespace Paparee\BaleDisnaker\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Paparee\BaleDisnaker\Casts\EncryptedData;
use Paparee\BaleDisnaker\Casts\EncryptedNik;

class CitizenProfile extends Model
{
    use HasUuids;

    protected $table = 'pelatihan_citizen_profiles';

    protected $guarded = [];

    protected $casts = [
        'nik' => EncryptedNik::class,
        'whatsapp' => EncryptedData::class,
        'completed_at' => 'datetime',
    ];
}
