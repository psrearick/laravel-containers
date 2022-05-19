<?php

namespace Psrearick\Containers\Tests;

class ClearProperties
{
    /**
     * Unset each property declared in this test class and its traits.
     *
     * @return void
     */
    public function after() : void
    {
        ray(memory_get_usage());
    }

    public function before() : void
    {
        ray(memory_get_usage());
    }
}
