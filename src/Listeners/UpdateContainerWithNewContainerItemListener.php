<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerWithNewContainerItemListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        $containerItem = app(ContainerItemManagerService::class)
            ->service($event->container, $event->item)
            ->containerItem();

        if (! $containerItem->isSummarized()) {
            return;
        }

        app(UpdateContainerItemSummary::class)->execute($containerItem);
    }
}
