<?php

namespace Psrearick\Containers\Domain\Containers\Aggregate\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\ContainerItemEvent;

class ContainerItemWasSaved implements ContainerItemEvent
{
    use Dispatchable;
    use SerializesModels;

    public ContainerItem $containerItem;

    public function __construct(ContainerItem $containerItem)
    {
        $this->containerItem = $containerItem;
    }
}
