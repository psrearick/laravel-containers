<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an item can be created', function () {
    $data = ['name' => 'item'];
    $item = Item::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});

test('an item can be added to a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $item->addToContainer($container);

    $this->assertDatabaseCount('container_items', 1);
});
