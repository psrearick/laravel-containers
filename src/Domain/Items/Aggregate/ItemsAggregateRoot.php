<?php

namespace Psrearick\Containers\Domain\Items\Aggregate;

use Psrearick\Containers\Contracts\AggregateRoot;
use Psrearick\Containers\Contracts\Item;

class ItemsAggregateRoot implements AggregateRoot
{
    public array $containers = [];

    public Item $item;

    public ?int $quantity;
}
