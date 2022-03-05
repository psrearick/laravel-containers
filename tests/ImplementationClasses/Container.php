<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Traits\Containerable;
use Psrearick\Containers\Traits\ContainerBaseActions;
use Psrearick\Containers\Traits\ContainerBaseAttributes;

/**
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $deleted_at
 */
class Container extends Model implements ContainerContract
{
    use Containerable;
    use hasFactory;
    use ContainerBaseActions;
    use ContainerBaseAttributes;

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
