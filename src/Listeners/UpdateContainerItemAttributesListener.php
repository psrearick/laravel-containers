<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItem;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerItemAttributesListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        $containerItem = app(ContainerItemManagerService::class)
            ->service($event->container, $event->item)
            ->containerItem();
        app(UpdateContainerItem::class)->execute($containerItem);
    }
}
