<?php

namespace Psrearick\Containers\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Contracts\Summary;

class ContainerItemService
{
    private Container $container;

    private ?ContainerItem $containerItem = null;

    private ?collection $containerItems = null;

    private ?bool $exists = null;

    private Item $item;

    private ContainerItem $model;

    private ?Summary $summary = null;

    private Summary $summaryModel;

    public function computationsForItem() : array
    {
        return $this->model()->computations()[get_class($this->item)];
    }

    public function computationsForSummary() : array
    {
        return $this->summaryModel()->computations()[get_class($this->item)];
    }

    public function container() : Container
    {
        return $this->container;
    }

    public function containerItem() : ?ContainerItem
    {
        $this->setContainerItem();

        return $this->containerItem;
    }

    public function containerItems(bool $refresh = false) : Collection
    {
        if ($this->containerItems && ! $refresh) {
            return $this->containerItems;
        }

        $this->setContainerItems();

        return $this->containerItems;
    }

    public function create(array $attributes) : self
    {
        $containerItem = $this->relation('container', 'containerItem')->create(array_merge(
            [$this->foreignKey('item', 'containerItem') => $this->item->id],
            $attributes
        ));

        $this->setContainerItem($containerItem);

        return $this;
    }

    public function exists() : bool
    {
        if ($this->exists) {
            return true;
        }

        if ($this->containerItem !== null) {
            $this->exists = true;
        }

        if ($this->exists === null) {
            $this->exists = $this->item->containerItemExists($this->container, 'item');
        }

        return $this->exists;
    }

    public function foreignKey(string $from, string $to) : string
    {
        return $this->relation($from, $to)->getForeignKeyName();
    }

    public function getInstance(Container $container, Item $item) : self
    {
        $this->setContainer($container);
        $this->setItem($item);

        /** @var ContainerItem $relation */
        $relation = $item->getContainerItemRelationForContainer($container)->getModel();

        $this->model         = $relation;
        $this->containerItem = $this->exists() ? $item->getContainerItem($container, 'item') : null;

        if ($this->summarized()) {
            $this->summaryModel  = $this->model()->{$this->relationName('summary')}()->getModel();
        }

        return $this;
    }

    public function getInstanceFromContainerItem(ContainerItem $containerItem) : self
    {
        $this->setContainerItem($containerItem);
        $this->setItem();
        $this->setContainer();

        $this->model        = $containerItem;

        if ($this->summarized()) {
            $this->summaryModel = $containerItem->{$this->relationName('summary')}()->getModel();
        }

        return $this;
    }

    public function is(Container $container, Item $item) : bool
    {
        return $this->container()->is($container) && $this->item()->is($item);
    }

    public function isContainerItem(ContainerItem $containerItem) : bool
    {
        return $this->containerItem->is($containerItem);
    }

    public function item() : Item
    {
        return $this->item;
    }

    public function model() : ContainerItem
    {
        return $this->containerItem ?: $this->model;
    }

    public function quantityField() : string
    {
        return $this->model()->quantityFieldName();
    }

    public function relation(string $from, string $to) : HasMany|BelongsTo
    {
        if ($from === 'containerItem') {
            $relations = $this->model()->containerItemRelations();
            if ($to === 'summary') {
                return $this->model()->{$this->relationName('summary')}();
            }

            return $to === 'item'
                ? $this->model()->{$relations['item']}()
                : $this->model()->{$relations['container']}();
        }

        if ($from === 'summary') {
            return $this->summaryModel()->{$this->relationName($to, $from)}();
        }

        return $from === 'item'
            ? $this->item->getContainerItemRelationForContainer($this->container)
            : $this->container->getContainerItemRelationForItem($this->item);
    }

    public function relationName(string $to, string $from = 'containerItem') : string
    {
        if ($to === 'summary') {
            return $this->model()->summarizedBy();
        }

        if ($from === 'summary') {
            return $this->summaryModel()->containerItemSummaryRelations()[$to];
        }

        return $this->model()->containerItemRelations()[$to];
    }

    public function setContainer(?Container $container = null) : self
    {
        if (isset($this->container)) {
            return $this;
        }

        if ($container) {
            $this->container = $container;
        }

        if ($this->containerItem) {
            $this->container = $this->containerItem->{$this->relationName('container')};
        }

        return $this;
    }

    public function setContainerItem(?ContainerItem $containerItem = null) : self
    {
        $this->containerItem    = $this->getCurrentContainerItem($containerItem);

        return $this;
    }

    public function setContainerItems() : self
    {
        $this->containerItems = app(get_class($this->model))::query()
            ->where($this->foreignKey('containerItem', 'container'), '=', $this->container->id)
            ->where($this->foreignKey('containerItem', 'item'), '=', $this->item->id)
            ->get();

        return $this;
    }

    public function setItem(?Item $item = null) : self
    {
        if (isset($this->item)) {
            return $this;
        }

        if ($item) {
            $this->item = $item;
        }

        if ($this->containerItem) {
            $this->item = $this->containerItem->{$this->relationName('item')};
        }

        return $this;
    }

    public function setSummary(?Summary $summary = null) : self
    {
        if ($summary) {
            $this->summary = $summary;
        }

        if (isset($this->summary)) {
            return $this;
        }

        $this->summary = optional($this->containerItem())->{$this->relationName('summary')};

        return $this;
    }

    public function singleton() : bool
    {
        return $this->model()->isSingleton();
    }

    public function summarizable() : bool
    {
        return $this->item instanceof SummarizableItem && $this->container instanceof SummarizableContainer;
    }

    public function summarized() : bool
    {
        return $this->summarizable() && $this->model()->isSummarized();
    }

    public function summary() : ?Summary
    {
        $this->setSummary();

        return $this->summary;
    }

    public function summaryModel() : Summary
    {
        return $this->summary() ?: $this->summaryModel;
    }

    public function updateOrCreate(array $attributes) : self
    {
        if (! $this->containerItem) {
            $this->create($attributes);

            return $this;
        }

        $this->containerItem->update($attributes);

        return $this;
    }

    public function updateOrCreateSummary(array $attributes) : self
    {
        if ($this->summary) {
            $this->summary->update($attributes);

            return $this->associateSummary();
        }

        $summary = $this->relation('containerItem', 'summary')->create(array_merge(
            [
                $this->foreignKey('summary', 'container')   => $this->container->id,
                $this->foreignKey('summary', 'item')        => $this->item->id,
            ],
            $attributes
        ));

        $this->setSummary($summary);

        return $this->associateSummary();
    }

    private function associateSummary() : self
    {
        $this->relation('containerItem', 'summary')->associate($this->summary());
        $this->containerItem->save();

        return $this;
    }

    private function getCurrentContainerItem(?ContainerItem $containerItem = null) : ?ContainerItem
    {
        if ($containerItem) {
            return $containerItem;
        }

        if ($this->containerItems) {
            return $this->containerItems->sortBy('id')->last();
        }

        return $this->containerItem ?? $this->containerItems(true)->sortBy('id')->last();
    }
}
