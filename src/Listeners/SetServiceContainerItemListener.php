<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class SetServiceContainerItemListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        app(ContainerItemManagerService::class)
            ->service($event->container, $event->item)
            ->setContainerItems()
            ->setContainerItem();
    }
}
