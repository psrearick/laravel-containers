<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

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

        if (! $item->containerItemExists($container)) {
            $this->createNewContainerItem();

            return;
        }

        $this->containerItem = $item->getContainerItem($container);

        if ($this->containerItem->isSummarized()) {
            $this->getChange();
            $this->createNewContainerItem();

            return;
        }

        $this->containerItem->update($attributes);
        Event::dispatch(new ContainerItemWasUpdated($this->containerItem));
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
