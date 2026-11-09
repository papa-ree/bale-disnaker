<?php

namespace Paparee\BaleDisnaker\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Paparee\BaleDisnaker\Support\DataCrypto;

class EncryptedData implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return DataCrypto::decrypt($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return DataCrypto::encrypt($value === null ? null : (string) $value);
    }
}
