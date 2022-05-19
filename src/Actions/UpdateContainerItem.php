<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerItem
{
    public function execute(Container $parentContainer, Item $parentItem, Container $container, Item $item) : void
    {
        $childService           = app(ContainerItemManagerService::class)
            ->service($container, $item);
        $parentService          = app(ContainerItemManagerService::class)
            ->service($parentContainer, $parentItem);
        $parentContainerItem    = $parentService->containerItem();

        if (! $parentContainerItem) {
            return;
        }

        $childUpdates       = $childService->updates();
        $parentComputations = $parentService->computationsForSummary();
        $currentValues      = app(GetContainerItemTotals::class)
            ->execute($parentService->container(), $parentService->item());

        $attributes = collect($parentComputations)->map(
            function ($class, $field) use ($currentValues, $childUpdates, $parentContainerItem) {
                $action = $childUpdates[$field] >= 0 ? 'add' : 'remove';

                return app($class[$action])->execute(
                    $currentValues[$field] ?? 0,
                    $childUpdates[$field] ?? 0,
                    [
                        'model'             => $parentContainerItem,
                        'quantityFieldName' => $parentContainerItem->quantityFieldName(),
                        'fieldName'         => $field,
                        'attributes'        => $childUpdates,
                    ]
                );
            }
        )->all();

        $attributes = array_filter($attributes, function ($value, $field) use ($parentComputations) {
            return array_key_exists($field, $parentComputations);
        }, ARRAY_FILTER_USE_BOTH);

        app(SetContainerItemAttributes::class)
            ->execute($parentService->container(), $parentService->item(), $attributes);
    }
}
