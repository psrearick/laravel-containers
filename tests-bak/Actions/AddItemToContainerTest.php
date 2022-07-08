<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Outer;

test('an item cannot be added to a container without a quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item);

    $this->assertDatabaseCount('container_items', 0);
});

test('a singleton item can be added to a container without a quantity', function () {
    /** @var Outer $container */
    $container = Outer::factory()->create();

    /** @var Container $item */
    $item = Container::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item);

    $this->assertDatabaseCount('container_outers', 1);
});

test('an item can be added to a container at least once', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 1]);

    $this->assertDatabaseCount('container_items', 1);
    $this->assertEquals(1, $item->getContainerItem($container)->quantity);
});

test('multiple items can be added to a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item1 */
    $item1 = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item1, ['quantity' => 2]);

    /** @var Item $item2 */
    $item2 = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item2, ['quantity' => 3]);

    $this->assertDatabaseCount('container_items', 2);
    $this->assertEquals(2, $item1->getContainerItem($container)->quantity);
    $this->assertEquals(3, $item2->getContainerItem($container)->quantity);
});

test('an item can be added to a summarized container multiples times to create multiple container item records', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 1]);
    $this->assertEquals(1, $item->getContainerItem($container)->quantity);

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 4]);
    $this->assertEquals(4, $item->getContainerItem($container)->quantity);

    $this->assertDatabaseCount('container_items', 2);
});

test('an item added to a non-summarized container multiple times does not create multiple container item records', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 1]);
    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 2]);

    $this->assertEquals(3, $item->getContainerItem($container)->quantity);
    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
});
