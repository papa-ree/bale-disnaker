<?php

namespace Paparee\BaleDisnaker\Livewire\LandingPage\Home;

use Bale\Umpak\Livewire\UmpakComponent;
use Illuminate\Support\Facades\Cache;
use Paparee\BaleDisnaker\Models\Cluster;
use Paparee\BaleDisnaker\Models\Period;
use Paparee\BaleDisnaker\Models\Submission;

/**
 * Ringkasan publik klaster pelatihan yang sudah disetujui.
 *
 * Hanya klaster `approved` yang tampil; periode yang dipakai adalah periode
 * terakhir yang punya klaster disetujui, bukan selalu periode aktif.
 * Section disembunyikan bila `pelatihan-section` belum ada di CMS.
 */
class ClusterSection extends UmpakComponent
{
    public string $slug = 'pelatihan-section';

    public function mount(?string $slug = null): void
    {
        if ($slug) {
            $this->slug = $slug;
        }
    }

    public function render()
    {
        return view('bale-disnaker::livewire.landing-page.home.cluster-section', [
            'section' => $this->section($this->slug),
            'summary' => $this->summary(),
        ]);
    }

    private function summary(): ?array
    {
        $periodId = Cluster::query()
            ->where('status', Cluster::STATUS_APPROVED)
            ->latest('created_at')
            ->value('period_id');

        if (! $periodId) {
            return null;
        }

        // Cache dipakai bersama antar-bale; slug tenant wajib ada di key.
        $tenant = config('umpak.org_slug')
            ?: config('database.connections.'.config('database.default').'.database');

        return Cache::remember(
            'disnaker.cluster-section.'.$tenant.'.'.$periodId.'.v2',
            now()->addMinutes(10),
            function () use ($periodId) {
                $period = Period::find($periodId);

                $clusters = Cluster::query()
                    ->where('period_id', $periodId)
                    ->where('status', Cluster::STATUS_APPROVED)
                    ->withCount('submissions')
                    ->orderByDesc('submissions_count')
                    ->get(['id', 'name']);

                $types = Submission::query()
                    ->where('period_id', $periodId)
                    ->selectRaw('type, count(*) as total')
                    ->groupBy('type')
                    ->pluck('total', 'type');

                return [
                    'period_label' => trim(ucfirst((string) $period?->name).' · '.$period?->year, ' ·'),
                    'is_active_period' => (bool) $period?->is_active,
                    'analysed_at' => $period?->last_ai_run_at,
                    'total' => (int) $clusters->sum('submissions_count'),
                    'clusters' => $clusters->map(fn (Cluster $cluster) => [
                        'name' => $cluster->name,
                        'count' => (int) $cluster->submissions_count,
                    ])->all(),
                    'masyarakat' => (int) ($types['masyarakat'] ?? 0),
                    'perusahaan' => (int) ($types['perusahaan'] ?? 0),
                ];
            }
        );
    }
}
