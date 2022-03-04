<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Listeners;

use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasDeleted;

class AddItemToContainer
{
    public function handle(ItemWasDeleted $event) : void
    {
        //
    }
}
