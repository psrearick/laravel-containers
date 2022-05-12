<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\ContainerItem;

class ContainerItemWasUpdated
{
    use Dispatchable;
    use SerializesModels;

    public array $attributes;

    public ContainerItem $containerItem;

    public function __construct(ContainerItem $containerItem, array $attributes)
    {
        $this->containerItem = $containerItem;
        $this->attributes    = $attributes;
    }
}
