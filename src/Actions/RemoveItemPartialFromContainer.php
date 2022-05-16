<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;

class RemoveItemPartialFromContainer
{
    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $containerItem  = $item->getContainerItem($container);
        $quantityField  = $containerItem->quantityFieldName();
        $computations   = $containerItem->computations();
        $removeClass    = $computations[$quantityField]['remove'];

        $attributes[$quantityField] = app($removeClass)->execute($containerItem[$quantityField], $attributes[$quantityField]);

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);
    }
}
