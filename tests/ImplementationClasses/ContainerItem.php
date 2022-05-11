<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;

class ContainerItem extends Pivot implements ContainerItemContract
{
    public $incrementing = true;
}
