<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Listeners\UpdateContainerItemAttributesListener;
use Psrearick\Containers\Listeners\UpdateContainerItemParentListener;
use Psrearick\Containers\Listeners\UpdateContainerWithContainerItemListener;
use Psrearick\Containers\Listeners\UpdateContainerWithNewContainerItemListener;

class EventServiceProvider extends Provider
{
    protected $listen = [
        ContainerItemWasCreated::class => [
            UpdateContainerWithNewContainerItemListener::class,
            //            UpdateContainerItemAttributesListener::class,
        ],
        ContainerItemWasUpdated::class => [
            UpdateContainerWithContainerItemListener::class,
            UpdateContainerItemParentListener::class,
        ],
    ];
}
