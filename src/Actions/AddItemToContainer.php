<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Services\ContainerItemManagerService;

class AddItemToContainer
{
    public function execute(Container $container, Item $item, ?array $attributes = []) : void
    {
        $service = app(ContainerItemManagerService::class)->service($container, $item);

        $quantityField  = $service->quantityField();
        $computations   = $service->computationsForItem();

        if (($attributes[$quantityField] ?? 0) === 0 && ! $service->singleton()) {
            return;
        }

        $containerItem = $service->exists() ? $service->containerItem() : $service->model();

        $currentValues = ! $service->exists()
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
