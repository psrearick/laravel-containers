<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Services\ContainerItemManagerService;

class RemoveItemPartialFromContainer
{
    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $service        = app(ContainerItemManagerService::class)->service($container, $item);
        $containerItem  = $service->containerItem();
        $currentValues  = app(GetContainerItemTotals::class)
            ->execute($container, $item);

        $attributes = collect($service->computationsForItem())->map(
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
