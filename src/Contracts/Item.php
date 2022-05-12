<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method Item refresh()
 */
interface Item extends Model
{
    /** provide an array of computation classes available to this item */
    public function computations() : array;

    /** provide an array that maps related classes to their ContainerItem relation */
    public function containerItemRelations() : array;

    /**
     * Get the most recent ContainerItem relating this record with its
     * corresponding Container
     */
    public function getContainerItem(Container|Item $record) : ContainerItem;

    /** Get the ContainerItem relation with the provided Container */
    public function getContainerItemRelationForContainer(Container $container) : HasMany;

    /**
     * Get a collection of ContainerItem instances that relate to this item
     * and the Container provided
     */
    public function getContainerRelationRecords(Container $container) : Collection;

    /** Get a collection of all containers of this item */
    public function getContainersOfType(string $class) : Collection;

    /** Get the foreign key name for the ContainerItem relationship */
    public function getItemForeignKeyName(Container $container) : string;

    /** Get the Container this item was most recently added to */
    public function getLatestContainerOfType(string $class) : Container;
}
