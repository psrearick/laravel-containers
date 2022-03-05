<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\ItemEvent;

class ItemWasCreated implements ItemEvent
{
    use Dispatchable;
    use SerializesModels;

    public Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }
}
