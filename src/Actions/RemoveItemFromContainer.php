<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Services\ContainerItemManagerService;

class RemoveItemFromContainer
{
    public function execute(Container $container, Item $item) : void
    {
        $service    = app(ContainerItemManagerService::class)->service($container, $item);
        $attributes = app(GetContainerItemTotals::class)->execute($container, $item);

        $attributes[$service->quantityField()] = 0;

        app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);
    }
}
