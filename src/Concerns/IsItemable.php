<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;

trait IsItemable
{
    public static function bootIsItemable() : void
    {
        static::created(static function (ItemContract $item) {
            Event::dispatch(new ItemWasCreated($item));
        });
    }

    public function containerItem(Container $container) : ContainerItem
    {
        $relation = $this->relationName($container);

        return $this->$relation->first()->pivot;
    }

    public function relationName(Container $container) : string
    {
        return $this->containedBy()[get_class($container)];
    }
}