<?php

namespace Paparee\BaleDisnaker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Paparee\BaleDisnaker\BaleDisnaker
 */
class BaleDisnaker extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Paparee\BaleDisnaker\BaleDisnaker::class;
    }
}
