<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;

trait IsItemable
{
    public function addToContainer(Container $container, ?array $attributes = []) : void
    {
        app(AddItemToContainer::class)->execute($container, $this, $attributes);
    }

    public static function bootIsItemable() : void
    {
        static::created(static function (ItemContract $item) {
            Event::dispatch(new ItemWasCreated($item));
        });
    }

    public function containerItem(Container $container) : ?ContainerItem
    {
        $relation = $this->relationName($container);

        return optional($this->$relation->first())->pivot;
    }

    public function lastContainerItem(Container $container) : ?ContainerItem
    {
        $relation = $this->relationName($container);

        return optional($this->$relation->last())->pivot;
    }

    public function relationName(Container $container) : string
    {
        return $this->containedBy()[get_class($container)];
    }
}
