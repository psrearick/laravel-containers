<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Events\AddingItemToContainer;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Events\RemovingItemFromContainer;
use Psrearick\Containers\Events\SettingContainerItemAttributes;
use Psrearick\Containers\Listeners\AddItemToContainerListener;
use Psrearick\Containers\Listeners\RemoveItemFromContainerListener;
use Psrearick\Containers\Listeners\SetContainerItemAttributesListener;
use Psrearick\Containers\Listeners\SetServiceContainerItemListener;
use Psrearick\Containers\Listeners\UpdateContainerItemParentListener;
use Psrearick\Containers\Listeners\UpdateContainerWithContainerItemListener;
use Psrearick\Containers\Listeners\UpdateContainerWithNewContainerItemListener;

class EventServiceProvider extends Provider
{
    protected $listen = [
        AddingItemToContainer::class => [
            AddItemToContainerListener::class,
        ],
        ContainerItemWasCreated::class => [
            SetServiceContainerItemListener::class,
            UpdateContainerWithNewContainerItemListener::class,
            UpdateContainerItemParentListener::class,
        ],
        ContainerItemWasUpdated::class => [
            UpdateContainerWithContainerItemListener::class,
            UpdateContainerItemParentListener::class,
        ],
        RemovingItemFromContainer::class => [
            RemoveItemFromContainerListener::class,
        ],
        SettingContainerItemAttributes::class => [
            SetContainerItemAttributesListener::class,
        ],
    ];
}
