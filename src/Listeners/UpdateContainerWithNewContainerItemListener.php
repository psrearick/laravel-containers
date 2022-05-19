<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerWithNewContainerItemListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        $service = app(ContainerItemManagerService::class)
            ->service($event->container, $event->item);

        if (! $service->summarized()) {
            return;
        }

        if (! $service->containerItem()) {
            return;
        }

        app(UpdateContainerItemSummary::class)->execute($event->container, $event->item);
    }
}
