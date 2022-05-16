<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a container can be created', function () {
    $data      = ['name' => 'container'];
    $container = Container::factory()->create($data);

    $this->assertDatabaseHas($container, $data);
});

test('a container can receive an item', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item);

    $this->assertDatabaseCount('container_items', 1);
});
