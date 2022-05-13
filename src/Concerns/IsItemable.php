<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\RemoveItemFromContainer;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;

trait IsItemable
{
    use HasContainerItemRelation;

    /** Add the current item to the provided container with the provided attributes */
    public function addToContainer(Container $container, ?array $attributes = []) : void
    {
        app(AddItemToContainer::class)->execute($container, $this, $attributes);
    }

    /** Remove the current item from the provided container */
    public function removeFromContainer(Container $container) : void
    {
        app(RemoveItemFromContainer::class)->execute($this, $container);
    }

    public static function bootIsItemable() : void
    {
        static::created(static function (ItemContract $item) {
            Event::dispatch(new ItemWasCreated($item));
        });
    }

    /** Get the ContainerItem relation with the provided Container */
    public function getContainerItemRelationForContainer(Container $container) : HasMany
    {
        return $this->getContainerItemRelationOfType(get_class($container), 'item');
    }

    /**
     * Get a collection of ContainerItem instances that relate to this item
     * and the Container provided
     */
    public function getContainerRelationRecords(Container $container) : Collection
    {
        return $this->getContainerItemRelationForContainer($container)->get();
    }

    /** Get a collection of all containers of this item */
    public function getContainersOfType(string $class) : Collection
    {
        return $this->getRelatedRecordsForRelation($class, 'container', 'item');
    }

    /** Get the foreign key name for the ContainerItem relationship */
    public function getItemForeignKeyName(Container $container) : string
    {
        return $this->{$this->getRelationNameForContainer($container)}()->getForeignKeyName();
    }

    /** Get the Container this item was most recently added to */
    public function getLatestContainerOfType(string $class) : ?Container
    {
        return $this->getContainersOfType($class)->last();
    }

    /**
     * Get the name of the relation on the ContainerItem instance
     * that relates to this item
     */
    protected function getRelationNameForContainer(Container $container) : ?string
    {
        return $this->getRelationName(get_class($container), 'item');
    }
}
