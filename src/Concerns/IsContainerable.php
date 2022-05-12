<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerWasCreated;

trait IsContainerable
{
    public static function bootIsContainerable() : void
    {
        static::created(function (ContainerContract $container) {
            Event::dispatch(new ContainerWasCreated($container));
        });
    }

    public function itemRelationName(Item $item) : string
    {
        return $this->containerItemRelations()[get_class($item)];
    }

    public function itemRelationRecords(Item $item) : Collection
    {
        $relation        = $this->{$this->itemRelationName($item)}();
        $foreignRelation = $item->{$item->containerRelationName($this)}();

        return $relation->where($foreignRelation->getForeignKeyName(), '=', $item->id)->get();
    }

    public function receiveItem(Item $item, ?array $attributes = []) : void
    {
        app(AddItemToContainer::class)->execute($this, $item, $attributes);
    }
}
