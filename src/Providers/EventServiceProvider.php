<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerItemWasSaved;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Domain\Items\Aggregate\Listeners\AddItem;
use Psrearick\Containers\Domain\Summaries\Aggregate\Listeners\UpdateContainerSummary;

class EventServiceProvider extends Provider
{
    protected $listen = [
        ItemWasCreated::class => [
            AddItem::class,
        ],
        ContainerItemWasSaved::class => [
            UpdateContainerSummary::class,
        ],
    ];
}
