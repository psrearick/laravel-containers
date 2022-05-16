<?php

namespace Psrearick\Containers\Contracts;

use Psrearick\Containers\Tests\ImplementationClasses\ContainerItemSummary;

/**
 * @method ContainerItem refresh()
 * @method ContainerItem update(array $update)
 * @method ContainerItem save()
 * @method ContainerItem create(array $values)
 *
 * @property ContainerItemSummary $containerItemSummary
 */
interface ContainerItem extends Model
{
    /** provide an array of computation classes available to this container item */
    public function computations() : array;

    public function containerItemRelations() : array;

    /** specify if the container item quantity must be no more than one  */
    public function isSingleton() : bool;

    /**
     * Specify if the container item is summarized. Summarized container items have multiple container item
     * records for each container item relationship and the record values are summarized in a separate table.
     * A non-summarized container item is updated each time a value changes and is used to get the totals.
     */
    public function isSummarized() : bool;

    /** The name of the field use to define the container item quantity */
    public function quantityFieldName() : string;
}
