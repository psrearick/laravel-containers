<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Models\Base\Item;

class ItemWasUpdated
{
    use Dispatchable;
    use SerializesModels;

    public Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }
}
