<?php

namespace Psrearick\Containers\Models;

use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Models\Base\Container as Base;

class Container extends Base
{
    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
