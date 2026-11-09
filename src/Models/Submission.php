<?php

namespace Paparee\BaleDisnaker\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasUuids;

    public const STATUS_PENDING = 'Pending_AI_Processing';

    protected $table = 'pelatihan_submissions';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
        'ai_processed_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    /**
     * Hanya klaster yang sudah disetujui admin boleh tampil ke warga.
     */
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id')
            ->where('status', Cluster::STATUS_APPROVED);
    }

    /**
     * Warga tidak perlu tahu detail status internal AI; cukup dua label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'AI_Processed'
            ? __('Sudah Diproses')
            : __('Sedang Diproses');
    }
}
