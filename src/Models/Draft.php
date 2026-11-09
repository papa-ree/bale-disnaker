<?php

namespace Paparee\BaleDisnaker\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasUuids;

    protected $table = 'pelatihan_drafts';

    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'step' => 'integer',
    ];
}
