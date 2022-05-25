<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @method Container refresh()
 * @method bool is(?Container $model)
 * @property Collection $containerItems
 */
interface Container extends Model
{
    /** check if there is a container item for the provided container */
    public function containerItemExists(Container|Item $record, string $key = '') : bool;

    /** provide an array that maps related classes to their ContainerItem relation */
    public function containerItemRelations() : array;

    /** Remove the provided item from the current container */
    public function discardItem(Item $item) : void;

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
