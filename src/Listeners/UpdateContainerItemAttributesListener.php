<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItem;
use Psrearick\Containers\Events\ContainerItemWasCreated;

class UpdateContainerItemAttributesListener
{
    public function handle(ContainerItemWasCreated $event) : void
    {
        app(UpdateContainerItem::class)->execute($event->containerItem);
    }
}
