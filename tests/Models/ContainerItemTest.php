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
