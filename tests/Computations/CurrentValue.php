<?php

namespace Psrearick\Containers\Tests\Computations;

use Psrearick\Containers\Contracts\Computation;

class CurrentValue implements Computation
{

    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []): mixed
    {
//        ray()->trace();
//        ray($currentValue, $newValue, $ref);

        return $newValue;
    }
}
