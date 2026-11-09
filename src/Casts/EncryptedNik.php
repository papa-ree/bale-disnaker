<?php

namespace Paparee\BaleDisnaker\Casts;

use Illuminate\Database\Eloquent\Model;
use Paparee\BaleDisnaker\Support\DataCrypto;

/**
 * Sama seperti EncryptedData, tetapi sekaligus mengisi `nik_hash` supaya
 * admin bisa mencari NIK dengan exact match.
 */
class EncryptedNik extends EncryptedData
{
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        $plain = ($value === null || $value === '') ? null : (string) $value;

        return [
            $key => DataCrypto::encrypt($plain),
            'nik_hash' => DataCrypto::hash($plain),
        ];
    }
}
