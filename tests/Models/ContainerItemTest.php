<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a container can receive an item', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item);

    $this->assertDatabaseCount('container_item', 1);
});

test('an item can be added to a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $item->addToContainer($container);

    $this->assertDatabaseCount('container_item', 1);
});

test('multiple items can be added to a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item1 = Item::factory()->create();
    $item1->addToContainer($container);

    /** @var Item $item */
    $item2 = Item::factory()->create();
    $item2->addToContainer($container);

    $this->assertDatabaseCount('container_item', 2);
});

test('an item can be added to a summarized container multiple times to create multiple container items', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container);
    $item->addToContainer($container);

    $this->assertDatabaseCount('container_item', 2);
});

test('an item cannot be added to a non-summarized container multiple times to create multiple container items', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container);
    $item->containerItem($container)->isSummarized = false;
    $item->addToContainer($container);

    $this->assertDatabaseCount('container_item', 1);
});
