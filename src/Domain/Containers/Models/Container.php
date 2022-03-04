<?php

namespace Psrearick\Containers\Domain\Containers\Models;

use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Domain\Containers\Models\Base\Container as Base;

class Container extends Base
{
    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
