<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContainerOuter extends Pivot
{
    public $incrementing = true;
}
