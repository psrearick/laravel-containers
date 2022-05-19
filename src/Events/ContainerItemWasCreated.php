<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;

class ContainerItemWasCreated
{
    use Dispatchable;
    use SerializesModels;

    public Container $container;

    public Item $item;

    public function __construct(Container $container, Item $item)
    {
        $this->container = $container;
        $this->item      = $item;
    }
}
