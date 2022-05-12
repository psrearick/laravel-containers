<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('a container can receive an item', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item);

    $this->assertDatabaseCount('container_items', 1);
});

test('an item can be added to a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $item->addToContainer($container);

    $this->assertDatabaseCount('container_items', 1);
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

    $this->assertDatabaseCount('container_items', 2);
});

test('an item can be added to a summarized container multiple times to create multiple container items', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container);
    $item->addToContainer($container);

    $this->assertDatabaseCount('container_items', 2);
});

test('an item cannot be added to a non-summarized container multiple times to create multiple container items', function () {
    /** @var Container $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var Item $item */
    $item = ItemNotSummarized::factory()->create();

    $item->addToContainer($container);
    $rec = $item->containerRelationRecords($container)->last();
    $item->addToContainer($container);

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
});
