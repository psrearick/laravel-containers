<?php

namespace Psrearick\Containers\Contracts;

use Psrearick\Containers\Tests\ImplementationClasses\ContainerItemSummary;

/**
 * @method ContainerItem refresh()
 * @method ContainerItem update(array $update)
 * @method ContainerItem save()
 *
 * @property ContainerItemSummary $containerItemSummary
 */
interface ContainerItem extends Model
{
    public function containerItemRelations() : array;

    public function isSummarized() : bool;
}
