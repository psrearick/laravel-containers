<?php

namespace Psrearick\Containers\Domain\Items\Aggregate;

use Psrearick\Containers\Contracts\Item;

class ItemsAggregateRoot
{
    public array $containers = [];

    public Item $item;

    public ?int $quantity;
}
