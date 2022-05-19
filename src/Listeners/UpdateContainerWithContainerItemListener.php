<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Contracts\Summarized;
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

        /** @var Summarized $summarized */
        $summarized = $service->containerItem();
        app(UpdateContainerItemSummary::class)->execute($summarized);
    }
}
