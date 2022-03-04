<?php

namespace Psrearick\Containers\Domain\Containers\Models;

use Psrearick\Containers\Database\Factories\ContainerItemFactory;
use Psrearick\Containers\Domain\Base\Model;
use Psrearick\Containers\Traits\ContainerItemable;

class ContainerItem extends Model
{
    use ContainerItemable;

    protected static function newFactory() : ContainerItemFactory
    {
        return ContainerItemFactory::new();
    }
}
