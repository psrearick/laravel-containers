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

    public function isSummarized() : bool;

    /** The name of the field use to define the container item quantity */
    public function quantityFieldName() : string;
}
