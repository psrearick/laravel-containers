<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;

class RemoveItemPartialFromContainer
{
    public function execute(Container $container, Item $item, array $attributeChange) : void
    {
        $totals = app(GetContainerItemTotals::class)->execute($container, $item);

        ray($totals, $attributeChange);
    }
}
