<?php

namespace Psrearick\Containers\Computations;

class Sum
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []) : float
    {
        return $currentValue + $newValue;
    }
}
