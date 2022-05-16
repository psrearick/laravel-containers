<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
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

    $container->receiveItem($item, ['quantity' => 1]);

    $this->assertDatabaseCount('container_items', 1);
});

test('a container can remove part of its children quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5]);
    $container->discardPartialItem($item, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
});
