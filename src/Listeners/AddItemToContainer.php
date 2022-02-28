<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Events\ItemWasDeleted;

class AddItemToContainer
{
    public function handle(ItemWasDeleted $event) : void
    {
        //
    }
}
