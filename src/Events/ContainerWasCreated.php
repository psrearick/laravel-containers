<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\Container;

class ContainerWasCreated
{
    use Dispatchable;
    use SerializesModels;

    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
