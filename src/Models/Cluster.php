<?php

namespace Paparee\BaleDisnaker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    public const STATUS_APPROVED = 'approved';

    protected $table = 'pelatihan_clusters';

    // UUID primary key dari admin.
    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'cluster_id');
    }
}
