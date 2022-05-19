<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerItem
{
    public function execute(?ContainerItem $parentContainerItem, ContainerItem $updatedContainerItem, array $updates) : void
    {
        if (! $parentContainerItem) {
            return;
        }

        $childService       = app(ContainerItemManagerService::class)->serviceFromContainerItem($updatedContainerItem);
        $childUpdates       = $childService->updates();
        $parentService      = app(ContainerItemManagerService::class)->serviceFromContainerItem($parentContainerItem);
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
