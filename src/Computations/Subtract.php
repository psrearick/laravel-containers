<?php

namespace Psrearick\Containers\Computations;

use Psrearick\Containers\Contracts\Computation;

class Subtract implements Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []) : float
    {
        return $currentValue - abs($newValue);
    }
}
