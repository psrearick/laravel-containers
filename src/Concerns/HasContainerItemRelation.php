<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;

trait HasContainerItemRelation
{
    /**
     * Get the most recent ContainerItem relating this record with its
     * corresponding Container / Item
     */
    public function getContainerItem(Container|Item $record) : ContainerItem
    {
        $containerItem = $this->getContainerItemRelationOfType(get_class($record))->latest()->first();

        if (! $containerItem instanceof ContainerItem) {
            throw new ContainerItemNotFoundException();
        }

        return $containerItem;
    }

    /**
     * Get the ContainerItem relation for the current record that
     * corresponds to the provided Container / Item class
     */
    protected function getContainerItemRelationOfType(string $relationClass) : HasMany
    {
        return $this->{$this->getRelationName($relationClass)}();
    }

    /**
     * Get collection of the related records for the current class of the provided type
     *
     * For example: for this Item, get all related Containers
     */
    protected function getRelatedRecordsForRelation(string $relationClass, string $relationType) : Collection
    {
        $relation = $this->getContainerItemRelationOfType($relationClass);
        $model    = $relation->getRelated();

        if (! method_exists($model, 'containerItemRelations')) {
            throw new ContainerItemNotFoundException('container item relations not defined');
        }

        $relationRelationName = $model->containerItemRelations()[$relationType];

        return $relation->get()->map(function (ContainerItem $containerItem) use ($relationRelationName) {
            return $containerItem->$relationRelationName;
        });
    }

    /** Get the ContainerItem relation name for the provided class */
    protected function getRelationName(string $class) : ?string
    {
        return $this->containerItemRelations()[$class] ?? null;
    }
}
