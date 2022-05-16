<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Events\ContainerItemWasCreated;

class UpdateContainerWithNewContainerItemListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        if (! $event->containerItem->isSummarized()) {
            return;
        }

        /** @var Summarized $summarized */
        $summarized = $event->containerItem;
        app(UpdateContainerItemSummary::class)->execute($summarized);
    }
}
