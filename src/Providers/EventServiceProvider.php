<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Listeners\AddItemToContainer;

class EventServiceProvider extends Provider
{
    protected $listen = [
        ItemWasCreated::class => [
            AddItemToContainer::class,
        ],
    ];
}
