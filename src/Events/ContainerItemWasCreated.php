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

    public array $attributes;

    public Container $container;

    public Item $item;

    public function __construct(Container $container, Item $item, array $attributes = [])
    {
        $this->container  = $container;
        $this->item       = $item;
        $this->attributes = $attributes;
    }
}
