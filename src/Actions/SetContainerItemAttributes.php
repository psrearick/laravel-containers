<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Events\ItemWasRemovedFromContainer;
use Psrearick\Containers\Services\ContainerItemManagerService;
use Psrearick\Containers\Services\ContainerItemService;

class SetContainerItemAttributes
{
    private array $attributes;

    private bool $remove = false;

    private ContainerItemService $service;

    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $this->service = app(ContainerItemManagerService::class)->service($container, $item);

        $this->attributes = $attributes;

        if (! $this->service->exists()) {
            $this->createNewContainerItem();

            return;
        }

        if ($this->service->summarized() && ! $this->service->singleton()) {
            $this->getChange();
            $this->createNewContainerItem();
            $this->checkForItemRemoval();

            return;
        }

        $this->service->updateOrCreate($attributes);
        Event::dispatch(new ContainerItemWasUpdated($this->service->container(), $this->service->item(), $attributes));
        $this->checkForItemRemoval();
    }

    private function checkForItemRemoval() : void
    {
        if (! $this->remove) {
            return;
        }

        Event::dispatch(new ItemWasRemovedFromContainer($this->service->container(), $this->service->item()));
    }

    private function createNewContainerItem() : void
    {
        $this->service->create($this->attributes);

        Event::dispatch(new ContainerItemWasCreated($this->service->container(), $this->service->item(), $this->attributes));
    }

    private function getChange() : void
    {
        if ($this->service->singleton()) {
            $this->attributes['quantity'] ??= 1;

            return;
        }

        $totals         = app(GetContainerItemTotals::class)
            ->execute($this->service->container(), $this->service->item());
        $quantityField  = $this->service->quantityField();
        $quantity       = $totals[$quantityField];
        $newQuantity    = $this->attributes[$quantityField];

        if ($newQuantity === 0) {
            $this->remove = true;
        }

        $this->attributes[$quantityField] = $newQuantity - $quantity;
    }
}
