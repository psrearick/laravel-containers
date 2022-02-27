<?php

namespace Psrearick\Containers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Psrearick\Containers\Containers
 */
class Containers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-containers';
    }
}
