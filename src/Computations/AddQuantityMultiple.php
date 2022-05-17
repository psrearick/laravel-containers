<?php

namespace Psrearick\Containers\Computations;

use Psrearick\Containers\Computations\Actions\GetQuantityMultipleResult;
use Psrearick\Containers\Contracts\Computation;

class AddQuantityMultiple implements Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []): float
    {
        return $currentValue + app(GetQuantityMultipleResult::class)->execute($ref, $newValue);
    }
}
