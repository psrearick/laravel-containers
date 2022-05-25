<?php

namespace Psrearick\Containers;

use Event;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\Summary;
use Psrearick\Containers\Events\AddingItemToContainer;
use Psrearick\Containers\Events\RemovingItemFromContainer;
use Psrearick\Containers\Events\SettingContainerItemAttributes;

class Containers
{
    private ?Container $container;

    private ?Item $item;

    public function __construct()
    {
        $this->container = null;
        $this->item      = null;
    }

    public function add(array $attributes = []) : self
    {
        Event::dispatch(new AddingItemToContainer($this->container, $this->item, $attributes));

        return $this;
    }

    public function container(Container $container) : self
    {
        $this->container = $container;

        return $this;
    }

    public function getContainer() : ?Container
    {
        return $this->container;
    }

    public function getContainerItem() : ContainerItem
    {
        return $this->item->getContainerItem($this->container, 'item');
    }

    public function getInstance(Container $container, Item $item) : self
    {
        $this->container = $container;
        $this->item      = $item;

        return $this;
    }

    public function getItem() : ?Item
    {
        return $this->item;
    }

    public function getSummary() : ?Summary
    {
        $containerItem = $this->getContainerItem();

        if (! $containerItem->isSummarized()) {
            return null;
        }

        $method = $containerItem->summarizedBy();

        return $containerItem->$method;
    }

    public function getTotals() : ?array
    {
        return app(GetContainerItemTotals::class)->execute($this->container, $this->item);
    }

    public function item(Item $item) : self
    {
        $this->item = $item;

        return $this;
    }

    public function remove(array $attributes = []) : self
    {
        Event::dispatch(new RemovingItemFromContainer($this->container, $this->item, $attributes));

        return $this;
    }

    public function set(array $attributes) : self
    {
        Event::dispatch(new SettingContainerItemAttributes($this->container, $this->item, $attributes));

        return $this;
    }
}
