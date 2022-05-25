<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\SetContainerItemAttributes;
use Psrearick\Containers\Events\SettingContainerItemAttributes;

class SetContainerItemAttributesListener
{
    public function handle(SettingContainerItemAttributes $event) : void
    {
        app(SetContainerItemAttributes::class)->execute($event->container, $event->item, $event->attributes);
    }
}
