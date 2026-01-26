<?php

namespace Paparee\BaleDisnaker\Commands;

use Illuminate\Console\Command;

class BaleDisnakerCommand extends Command
{
    public $signature = 'bale-disnaker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
