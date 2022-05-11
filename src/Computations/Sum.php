<?php

namespace Psrearick\Containers\Computations;

class Sum
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0) : float
    {
        return $currentValue + $newValue;
    }
}
