<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Events\ItemWasRemovedFromContainer;

class SetContainerItemAttributes
{
    private array $attributes;

    private Container $container;

    private ContainerItem $containerItem;

    private Item $item;

    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $this->attributes = $attributes;
        $this->container  = $container;
        $this->item       = $item;

        if (! $item->containerItemExists($container, 'item')) {
            $this->createNewContainerItem();

            return;
        }

        $this->containerItem = $item->getContainerItem($container, 'item');

        if ($this->containerItem->isSummarized()) {
            $this->getChange();
            $this->createNewContainerItem();
            $this->checkForItemRemoval();

            return;
        }

        $this->containerItem->update($attributes);
        Event::dispatch(new ContainerItemWasUpdated($this->containerItem));
        $this->checkForItemRemoval();
    }

    private function checkForItemRemoval() : void
    {
        $quantityField = $this->containerItem->quantityFieldName();
        if ($this->attributes[$quantityField] === 0) {
            return;
        }

        Event::dispatch(new ItemWasRemovedFromContainer($this->container, $this->item));
    }

    private function createNewContainerItem() : void
    {
        $containerItem = $this->container->getContainerItemRelationForItem($this->item)
            ->create(array_merge(
                [$this->item->getItemForeignKeyName($this->container) => $this->item->id],
                $this->attributes
            ));

        Event::dispatch(new ContainerItemWasCreated($containerItem));
    }

    private function getChange() : void
    {
        $totals         = app(GetContainerItemTotals::class)->execute($this->container, $this->item);
        $quantityField  = $this->containerItem->quantityFieldName();
        $quantity       = $totals[$quantityField];
        $newQuantity    = $this->attributes[$quantityField];

        $this->attributes[$quantityField] = $newQuantity - $quantity;
    }
}
