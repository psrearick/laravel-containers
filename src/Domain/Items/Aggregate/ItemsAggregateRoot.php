<?php

namespace Psrearick\Containers\Domain\Items\Aggregate;

use Psrearick\Containers\Computations\Difference;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Contracts\AggregateRoot;
use Psrearick\Containers\Contracts\Item;

class ItemsAggregateRoot implements AggregateRoot
{
    public array $containers = [];

    public Item $item;

    public function computationFields(): array
    {
        return [
            'quantity'  => Sum::class,
            'change'    => Difference::class,
        ];
    }
}
