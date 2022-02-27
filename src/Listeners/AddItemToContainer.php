<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Events\ItemWasCreated;

class AddItemToContainer
{
    public function handle(ItemWasCreated $event) : void
    {
        // create item
    }
}
