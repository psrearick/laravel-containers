<?php

namespace Psrearick\Containers\Domain\Containers\Aggregate\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerEvent;

class ContainerWasCreated implements ContainerEvent
{
    use Dispatchable;
    use SerializesModels;

    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
