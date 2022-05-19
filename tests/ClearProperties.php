<?php

namespace Psrearick\Containers\Tests;

use Psrearick\Containers\Services\ContainerItemManagerService;
use Psrearick\Containers\Services\ContainerItemService;

class ClearProperties
{
    /**
     * Unset each property declared in this test class and its traits.
     *
     * @return void
     */
    public function after(): void
    {
        ray(memory_get_usage());

    }

    public function before() : void
    {
        ray(memory_get_usage());
    }
}
