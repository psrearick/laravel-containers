<?php

namespace Psrearick\Containers\Contracts;

interface Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []) : mixed;
}
