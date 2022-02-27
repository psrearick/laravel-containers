<?php

namespace Psrearick\Containers\Listeners;

use Illuminate\Support\Str;
use Psrearick\Containers\Events\ItemWasCreated;

class AddItemToContainer
{
    public function handle(ItemWasCreated $event) : void
    {
        $event->item->update(['uuid' => Str::uuid()->toString()]);
    }
}
