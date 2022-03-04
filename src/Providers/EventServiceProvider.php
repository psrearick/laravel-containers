<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasDeleted;
use Psrearick\Containers\Domain\Items\Aggregate\Listeners\AddItemToContainer;

class EventServiceProvider extends Provider
{
    protected $listen = [
        //        ItemWasDeleted::class => [
        //            AddItemToContainer::class,
        //        ],
    ];
}
