<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Events\AddingItemToContainer;

class AddItemToContainerListener
{
    public function handle(AddingItemToContainer $event) : void
    {
        app(AddItemToContainer::class)->execute($event->container, $event->item, $event->attributes);
    }
}
