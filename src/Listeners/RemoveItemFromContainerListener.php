<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\RemoveItemFromContainer;
use Psrearick\Containers\Actions\RemoveItemPartialFromContainer;
use Psrearick\Containers\Events\RemovingItemFromContainer;

class RemoveItemFromContainerListener
{
    public function handle(RemovingItemFromContainer $event) : void
    {
        if ($event->attributes) {
            app(RemoveItemPartialFromContainer::class)->execute($event->container, $event->item, $event->attributes);

            return;
        }

        app(RemoveItemFromContainer::class)->execute($event->container, $event->item);
    }
}
