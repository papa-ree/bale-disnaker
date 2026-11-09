<?php

namespace Paparee\BaleDisnaker\Listeners;

use Bale\Tala\Events\TalaAuthenticated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Profil warga dibuat di sini supaya baris `sso_subject` tidak perlu ditebak
 * di sisi admin. Tala sendiri tidak tahu tabel pelatihan.
 */
class RecordCitizenProfile
{
    public function handle(TalaAuthenticated $event): void
    {
        $table = DB::table('pelatihan_citizen_profiles');

        if ($table->where('user_uuid', $event->user->uuid)->exists()) {
            $table->where('user_uuid', $event->user->uuid)->update([
                'sso_subject' => $event->remote->getId(),
                'updated_at' => now(),
            ]);

            return;
        }

        $table->insert([
            'id' => (string) Str::uuid7(),
            'user_uuid' => $event->user->uuid,
            'sso_subject' => $event->remote->getId(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
