<?php

namespace Psrearick\Containers\Domain\Containers\Aggregate;

use Psrearick\Containers\Contracts\AggregateRoot;

class ContainersAggregateRoot implements AggregateRoot
{
    public function computationFields(): array
    {
        return [];
    }
}
