<?php

namespace Psrearick\Containers\Domain\Containers\Models;

use Psrearick\Containers\Database\Factories\ContainerItemFactory;
use Psrearick\Containers\Domain\Containers\Models\Base\ContainerItem as Base;

class ContainerItem extends Base
{
    protected static function newFactory() : ContainerItemFactory
    {
        return ContainerItemFactory::new();
    }
}
