<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Traits\Containerable;

class Container extends Model implements ContainerContract
{
    use Containerable;
    use hasFactory;

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
