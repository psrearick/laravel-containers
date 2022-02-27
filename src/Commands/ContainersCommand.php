<?php

namespace Psrearick\Containers\Commands;

use Illuminate\Console\Command;

class ContainersCommand extends Command
{
    public $signature = 'laravel-containers';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
