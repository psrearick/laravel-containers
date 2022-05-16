<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;

class AddItemToContainer
{
    public function execute(Container $container, Item $item, ?array $attributes = []) : void
    {
        /** @var ContainerItem $model */
        $model          = $item->getContainerItemRelationForContainer($container)->getModel();
        $quantityField  = $model->quantityFieldName();
        $computations   = $model->computations();
        $additionClass  = $computations[$quantityField]['add'];

        if (($attributes[$quantityField] ?? 0) === 0 && ! $model->isSingleton()) {
            return;
        }

        $quantity = ! $item->containerItemExists($container, 'item') ? 0
            : app(GetContainerItemTotals::class)
                ->execute($container, $item)[$quantityField];

        $attributes[$quantityField] = app($additionClass)
            ->execute($quantity, $attributes[$quantityField] ?? 0);

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);

        /**
         * TODO: Remove item from either summary or current container
         * TODO: Make value field relative to quantity for outer
         */
    }
}
