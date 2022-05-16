<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Actions\RemoveItemFromContainer;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('an item cannot be removed from a container that it is not currently in', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $this->expectException(ContainerItemNotFoundException::class);
    app(RemoveItemFromContainer::class)->execute($container, $item);
});

test('an item can be removed from a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 5]);
    $this->assertEquals(5, $item->getContainerItem($container, 'item')->quantity);

    app(RemoveItemFromContainer::class)->execute($container, $item);
    $this->assertEquals(-5, $item->getContainerItem($container, 'item')->quantity);

    $this->assertDatabaseCount('container_items', 2);
    $this->expectException(ContainerItemNotFoundException::class);
    app(GetContainerItemTotals::class)->execute($container, $item);
});

test('an item removed from a non-summarized container has only one container item record', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 5]);
    $this->assertEquals(5, $item->getContainerItem($container, 'item')->quantity);

    app(RemoveItemFromContainer::class)->execute($container, $item);
    $this->assertEquals(0, $item->getContainerItem($container, 'item')->quantity);

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
    $this->expectException(ContainerItemNotFoundException::class);
    app(GetContainerItemTotals::class)->execute($container, $item);
});
