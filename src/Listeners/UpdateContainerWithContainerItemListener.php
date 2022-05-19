<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerWithContainerItemListener
{
    public function handle(ContainerItemWasUpdated $event) : void
    {
        $service = app(ContainerItemManagerService::class)->service($event->container, $event->item);
        if (! $service->summarized()) {
            return;
        }

        app(UpdateContainerItemSummary::class)->execute($event->container, $event->item);
    }
}
