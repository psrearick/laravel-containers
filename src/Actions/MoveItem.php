<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Services\ContainerItemManagerService;

class MoveItem
{
    public function execute(Container $container, Item $item, Container $newContainer, ?float $quantity = null) : void
    {
        $service = app(ContainerItemManagerService::class)->service($container, $item);
        if (! $service->containerItem()) {
            throw new ContainerItemNotFoundException();
        }

        if ($service->summarized()) {
            $summary = $service->summary();
            if (! $summary) {
                return;
            }

            app(ContainerItemManagerService::class)->service($newContainer, $item);
            $relation   = $summary->containerItemSummaryRelations()['container'];

            $summary->$relation()->associate($newContainer);
            $summary->save();

            app(AddItemToContainer::class)->execute($newContainer, $item, $service->containerItem()->toArray());
            app(RemoveItemFromContainer::class)->execute($container, $item);
            app(ContainerItemManagerService::class)->unsetService($container, $item);

            return;
        }

        $service->relation('containerItem', 'container')->associate($newContainer);
        $service->containerItem()->save();
        app(ContainerItemManagerService::class)->unsetService($container, $item);
    }
}
