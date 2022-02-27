<?php

namespace Psrearick\Containers\Commands;

use Illuminate\Console\Command;

class ContainersCommand extends Command
{
    public $description = 'My command';

    public $signature = 'laravel-containers';

    public function handle() : int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
