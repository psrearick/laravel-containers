<?php

namespace Psrearick\Containers\Models;

use Psrearick\Containers\Database\Factories\ContainerItemFactory;
use Psrearick\Containers\Models\Base\ContainerItem as Base;

class ContainerItem extends Base
{
    protected static function newFactory() : ContainerItemFactory
    {
        return ContainerItemFactory::new();
    }
}
