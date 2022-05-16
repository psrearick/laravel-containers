<?php

namespace Psrearick\Containers\Computations;

class Subtract
{
    public function execute(?float $currentValue = 0, ?float $change = 0) : float
    {
        return $currentValue - abs($change);
    }
}
