<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Listeners;

use Psrearick\Containers\Domain\Items\Aggregate\Actions\HandleItemEvent;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;

class AddItem
{
    public function handle(ItemWasCreated $event) : void
    {
        app(HandleItemEvent::class)->execute($event, 'created');
    }
}
