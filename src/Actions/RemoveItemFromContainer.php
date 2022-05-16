<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;

class RemoveItemFromContainer
{
    public function execute(Container $container, Item $item) : void
    {
        /** @var ContainerItem $model */
        $model          = $item->getContainerItemRelationForContainer($container)->getModel();
        $quantityField  = $model->quantityFieldName();
        $attributes     = app(GetContainerItemTotals::class)->execute($container, $item);

        $attributes[$quantityField] = 0;

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);
    }
}
