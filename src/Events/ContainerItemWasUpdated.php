<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\ContainerItem;

class ContainerItemWasUpdated
{
    use Dispatchable;
    use SerializesModels;

    public ContainerItem $containerItem;

    public function __construct(ContainerItem $containerItem)
    {
        $this->containerItem = $containerItem;
    }
}
