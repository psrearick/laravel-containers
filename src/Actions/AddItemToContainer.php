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
        $computations   = $model->computations()[get_class($item)];

        if (($attributes[$quantityField] ?? 0) === 0 && ! $model->isSingleton()) {
            return;
        }

        $containerItem = $item->containerItemExists($container, 'item')
            ? $item->getContainerItem($container, 'item')
            : $model;

        $currentValues = ! $item->containerItemExists($container, 'item')
            ? array_fill_keys(array_keys($computations), 0)
            : app(GetContainerItemTotals::class)
                ->execute($container, $item);

        $attributes = collect($computations)->map(
            function ($class, $field) use ($currentValues, $attributes, $containerItem) {
                return app($class['add'])->execute(
                    $currentValues[$field] ?? 0,
                    $attributes[$field] ?? 0,
                    [
                        'model'             => $containerItem,
                        'quantityFieldName' => $containerItem->quantityFieldName(),
                        'fieldName'         => $field,
                        'attributes'        => $attributes,
                    ]
                );
            }
        )->all();

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);
    }
}
