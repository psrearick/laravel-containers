<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;

/**
 * @property float $quantity
 * @property float $value
 */
class ContainerItem extends Pivot implements ContainerItemContract
{
    public $incrementing = true;
}
