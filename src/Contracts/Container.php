<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method Container refresh()
 * @property Collection $containerItems
 */
interface Container extends Model
{
    /** provide an array that maps related classes to their ContainerItem relation */
    public function containerItemRelations() : array;

    /** Get the foreign key name for the ContainerItem relationship */
    public function getContainerForeignKeyName(Item $item) : string;

    /** Get the ContainerItem relation with the provided Item */
    public function getContainerItemRelationForItem(Item $item) : HasMany;

    /**
     * Get a collection of ContainerItem instances that relate to this container
     * and the Item provided
     */
    public function getItemRelationRecords(Item $item) : Collection;

    /** Get a collection of all items in this container */
    public function getItemsOfType(string $class) : Collection;

    /** Get the item most recently added to this container */
    public function getLatestItemOfType(string $class) : Item;

    /** Add to the current container the provided item with the provided attributes */
    public function receiveItem(Item $item, ?array $attributes = []) : void;
}
