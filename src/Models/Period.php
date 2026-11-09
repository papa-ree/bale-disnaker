<?php

namespace Paparee\BaleDisnaker\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Baris `pelatihan_periods` di database tenant Disnaker. bale-front menulis
 * langsung ke database yang sama dengan bale-dev, tidak lewat API.
 */
class Period extends Model
{
    protected $table = 'pelatihan_periods';

    // UUID primary key dari admin; tanpa ini Eloquent meng-cast `id` ke int.
    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'year' => 'integer',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean',
        'last_ai_run_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function active(): ?self
    {
        return static::query()->active()->latest('created_at')->first();
    }
}
