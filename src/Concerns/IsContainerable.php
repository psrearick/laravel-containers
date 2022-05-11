<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerWasCreated;

trait IsContainerable
{
    public static function bootIsContainerable() : void
    {
        static::created(function (ContainerContract $container) {
            Event::dispatch(new ContainerWasCreated($container));
        });
    }

    public function receiveItem(Item $item, ?array $attributes) : void
    {
        $relation = $item->containedBy()[get_class($this)];
        $item->$relation()->attach($this->id);
        Event::dispatch(new ContainerItemWasCreated($this, $item, $attributes));
    }
}
