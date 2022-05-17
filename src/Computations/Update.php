<?php

namespace Psrearick\Containers\Computations;

use Psrearick\Containers\Contracts\Computation;

class Update implements Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []) : int|null|float
    {
        return $newValue;
    }
}
