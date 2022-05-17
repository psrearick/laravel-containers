<?php

namespace Psrearick\Containers\Computations;

use Psrearick\Containers\Computations\Actions\GetQuantityMultipleResult;
use Psrearick\Containers\Contracts\Computation;

class SubtractQuantityMultiple implements Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []): mixed
    {
        return $currentValue - app(GetQuantityMultipleResult::class)->execute($ref, $newValue);
    }
}
