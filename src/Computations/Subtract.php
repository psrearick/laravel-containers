<?php

namespace Psrearick\Containers\Computations;

class Subtract
{
    public function execute(?float $currentValue = 0, ?float $change = 0) : float
    {
        if ((float) $change < 0) {
            return $currentValue + $change;
        }

        return $currentValue - $change;
    }
}
