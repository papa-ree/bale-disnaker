<?php

namespace Paparee\BaleDisnaker\Exceptions;

use RuntimeException;

class WilayahUnavailable extends RuntimeException
{
    /**
     * True bila kegagalan berasal dari sesi SSO yang sudah berakhir, bukan
     * dari API wilayah yang sedang down.
     */
    public function __construct(string $message, public bool $sessionExpired = false)
    {
        parent::__construct($message);
    }
}
