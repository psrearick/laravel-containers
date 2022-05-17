<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Exceptions\MissingRelationshipException;
use Psrearick\Containers\Exceptions\PropertyNotDefinedException;

trait HasContainerItemRelation
{
    public function containerItemExists(Container|Item $record, string $key = '') : bool
    {
        return $this->getContainerItemRelationOfType(get_class($record), $key)->exists();
    }

    /**
     * Get the most recent ContainerItem relating this record with its
     * corresponding Container / Item
     */
    public function getContainerItem(Container|Item $record, string $key = '') : ContainerItem
    {
        $containerItem = $this->getContainerItemRelationOfType(get_class($record), $key)->orderByDesc('id')->first();

        if (! $containerItem instanceof ContainerItem) {
            throw new ContainerItemNotFoundException();
        }

        return $containerItem;
    }

    /** Get the key in the relations array used to define this relationship */
    protected function getContainerItemRelationKey(string $key = '') : string
    {
        if ($key) {
            return $key;
        }

        $isContainer = $this instanceof Container;
        $isItem      = $this instanceof Item;

        if ($isContainer && $isItem) {
            return $key;
        }

        if ($isContainer) {
            return 'container';
        }

        return 'item';
    }

    /**
     * Get the ContainerItem relation for the current record that
     * corresponds to the provided Container / Item class
     */
    protected function getContainerItemRelationOfType(string $relationClass, string $key = '') : HasMany
    {
        $method = $this->getRelationName($relationClass, $key);

        if (!$method) {
            throw new MissingRelationshipException();
        }

        return $this->{$method}();
    }

    /**
     * Get collection of the related records for the current class of the provided type
     *
     * For example: for this Item, get all related Containers
     */
    protected function getRelatedRecordsForRelation(string $relationClass, string $relationType, string $key = '') : Collection
    {
        $relation = $this->getContainerItemRelationOfType($relationClass, $key);
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
    protected function getRelationName(string $class, string $key = '') : string
    {
        $relations = $this->containerItemRelations();

        if (array_key_exists($class, $relations)) {
            return $relations[$class];
        }

        $relationKey = $this->getContainerItemRelationKey($key);

        if (! $relationKey) {
            return '';
        }

        if (array_key_exists($relationKey, $relations)) {
            $relations = $relations[$relationKey];
        }

        if (is_array($relations)) {
            return $relations[$class];
        }

        throw new PropertyNotDefinedException('The relation property is not defined');
    }
}
