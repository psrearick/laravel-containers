<?php

namespace Psrearick\Containers\Concerns;

use Illuminate\Database\Eloquent\Model;
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
        $containerItem = $this->find($record, $key);

        return $containerItem instanceof ContainerItem;
    }

    /**
     * Get the most recent ContainerItem relating this record with its
     * corresponding Container / Item
     */
    public function getContainerItem(Container|Item $record, string $key = '') : ContainerItem
    {
        $containerItem = $this->find($record, $key);

        if (! $containerItem instanceof ContainerItem) {
            throw new ContainerItemNotFoundException();
        }

        return $containerItem;
    }

    protected function find(Container|Item $record, string $key = '') : HasMany|null|Model
    {
        $relatedId             = $record->id;
        $containerItemRelation = $this->getContainerItemRelationOfType(get_class($record), $key);
        /** @var ContainerItem $containerItemModel */
        $containerItemModel    = $containerItemRelation->getRelated();

        if (! method_exists($containerItemModel, 'containerItemRelations')) {
            throw new ContainerItemNotFoundException('container item relations not defined');
        }

        $relationType       = $key === 'container' ? 'item' : 'container';
        $targetRelationName = $containerItemModel->containerItemRelations()[$relationType];
        $foreignKey         = $containerItemModel->{$targetRelationName}()->getForeignKeyName();

        return $containerItemRelation
            ->where($foreignKey, '=', $relatedId)
            ->orderByDesc('id')
            ->first();
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
            return 'item';
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

        if (! $method) {
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
        $containerItemRelation = $this->getContainerItemRelationOfType($relationClass, $key);
        /** @var ContainerItem $containerItemModel */
        $containerItemModel    = $containerItemRelation->getRelated();

        if (! method_exists($containerItemModel, 'containerItemRelations')) {
            throw new ContainerItemNotFoundException('container item relations not defined');
        }

        $targetRelationName         = $containerItemModel->containerItemRelations()[$relationType];
        $alternateRelationType      = $relationType === 'container' ? 'item' : 'container';
        $alternateRelationName      = $containerItemModel->containerItemRelations()[$alternateRelationType];
        $targetModel                = $containerItemModel->$targetRelationName()->getModel();
        $targetModelRelationName    = $targetModel->containerItemRelations()[$relationType][get_class($this)] ?? $targetModel->containerItemRelations()[__CLASS__];

        $relationNames = [
            $targetRelationName,
            "$targetRelationName.$targetModelRelationName",
            "$targetRelationName.$targetModelRelationName.$alternateRelationName",
        ];

        if ($containerItemModel->isSummarized()) {
            $summaryRelation = $containerItemModel->summarizedBy();
            $relationNames[] =
                "$targetRelationName.$targetModelRelationName.$summaryRelation";
        }

        return $containerItemRelation->with($relationNames)
            ->get()
            ->map(function (ContainerItem $containerItem) use ($targetRelationName) {
                return $containerItem->$targetRelationName;
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
