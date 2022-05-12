<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Collection;
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

//    public function firstContainerItem(Container $container) : ?ContainerItem
//    {
//        $relation = $this->relationName($container);
//
//        return $this->$relation->first();
//    }

    public function containerItem(Container $container) : ?ContainerItem
    {
        return $container->itemRelationRecords($this)->last();
    }

    public function containerRelationName(Container $container) : string
    {
        return $this->containerItemRelations()[get_class($container)];
    }

    public function containerRelationRecords(Container $container) : Collection
    {
        $relation        = $this->{$this->containerRelationName($container)}();
        $foreignRelation = $container->{$container->itemRelationName($this)}();

        return $relation->where($foreignRelation->getForeignKeyName(), '=', $container->id)->get();
    }
}
