<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\RemoveItemFromContainer;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerWasCreated;

trait IsContainerable
{
    use HasContainerItemRelation;

    public static function bootIsContainerable() : void
    {
        static::created(function (ContainerContract $container) {
            Event::dispatch(new ContainerWasCreated($container));
        });
    }

    /** Remove the provided item from the current container */
    public function discardItem(Item $item) : void
    {
        app(RemoveItemFromContainer::class)->execute($item, $this);
    }

    /** Get the foreign key name for the ContainerItem relationship */
    public function getContainerForeignKeyName(Item $item) : string
    {
        return $this->{$this->getRelationNameForItem($item)}()->getForeignKeyName();
    }

    /** Get the ContainerItem relation with the provided Item */
    public function getContainerItemRelationForItem(Item $item) : HasMany
    {
        return $this->getContainerItemRelationOfType(get_class($item), 'container');
    }

    /**
     * Get a collection of ContainerItem instances that relate to this container
     * and the Item provided
     */
    public function getItemRelationRecords(Item $item) : Collection
    {
        return $this->getContainerItemRelationForItem($item)->get();
    }

    /** Get a collection of all items in this container */
    public function getItemsOfType(string $class) : Collection
    {
        return $this->getRelatedRecordsForRelation($class, 'item', 'container');
    }

    /** Get the item most recently added to this container */
    public function getLatestItemOfType(string $class) : Item
    {
        return $this->getItemsOfType($class)->last();
    }

    /** Add to the current container the provided item with the provided attributes */
    public function receiveItem(Item $item, ?array $attributes = []) : void
    {
        app(AddItemToContainer::class)->execute($this, $item, $attributes);
    }

    /**
     * Get the name of the relation on the ContainerItem instance
     * that relates to this container
     */
    protected function getRelationNameForItem(Item $item) : string
    {
        return $this->getRelationName(get_class($item), 'container');
    }
}
