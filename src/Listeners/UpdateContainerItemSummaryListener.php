<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItemSummaryListener
{
    public function handle(ContainerItemWasUpdated $event) : void
    {
        if (! ($event->containerItem->isSummarized ?? false)) {
            return;
        }

        app(UpdateContainerItemSummary::class)->execute($event->containerItem);
    }
}
