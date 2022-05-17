<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;

class RemoveItemPartialFromContainer
{
    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $containerItem  = $item->getContainerItem($container);
        $computations   = $containerItem->computations()[get_class($item)];
        $currentValues  = app(GetContainerItemTotals::class)
            ->execute($container, $item);

        $attributes = collect($computations)->map(
            function ($class, $field) use ($currentValues, $attributes, $containerItem) {
                return app($class['remove'])->execute(
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
