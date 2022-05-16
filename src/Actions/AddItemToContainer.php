<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;

class AddItemToContainer
{
    public function execute(Container $container, Item $item, ?array $attributes = []) : void
    {
        /** @var ContainerItem $model */
        $model          = $item->getContainerItemRelationForContainer($container)->getModel();
        $quantityField  = $model->quantityFieldName();
        $computations   = $model->computations();
        $additionClass  = $computations[$quantityField]['add'];

        if (($attributes[$quantityField] ?? 0) === 0) {
            return;
        }

        $quantity = ! $item->containerItemExists($container, 'item') ? 0
            : app(GetContainerItemTotals::class)
                ->execute($container, $item)[$quantityField];

//        if ($relatedRecords->count() === 0) {
//            $containerItem = $relation->create(array_merge(
//                [$container->getContainerForeignKeyName($item) => $container->id],
//                $attributes,
//            ));
//
//            Event::dispatch(new ContainerItemWasCreated($containerItem));
//            return;
//        }

//        $quantity = app(GetContainerItemTotals::class)
//            ->execute($container, $item)[$quantityField];

        $attributes[$quantityField] = app($additionClass)
            ->execute($quantity, $attributes[$quantityField]);

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);

        /**
         * TODO: Add quantity to either summary or current container item
         * TODO: Test adding and item quantity multiple times
         * TODO: Test removing a quantity from an container item that has been added to multiple times
         * TODO: Remove item from either summary or current container
         * TODO: Make value field relative to quantity for outer
         */
    }
}
