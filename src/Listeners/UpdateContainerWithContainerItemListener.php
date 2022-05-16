<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerWithContainerItemListener
{
    public function handle(ContainerItemWasUpdated $event) : void
    {
        if (! $event->containerItem->isSummarized()) {
            return;
        }

        /** @var Summarized $summarized */
        $summarized = $event->containerItem;
        app(UpdateContainerItemSummary::class)->execute($summarized);
    }
}
