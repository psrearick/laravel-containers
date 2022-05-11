<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Listeners\UpdateContainerItemAttributesListener;

class EventServiceProvider extends Provider
{
    protected $listen = [
        ContainerItemWasCreated::class => [
            UpdateContainerItemAttributesListener::class,
        ],
    ];
}
