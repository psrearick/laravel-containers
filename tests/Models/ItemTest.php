<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
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

    $item->addToContainer($container, ['quantity' => 1]);

    $this->assertDatabaseCount('container_items', 1);
});

test('an item can remove part of is container quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5]);
    $item->removePartial($container, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
});

test('an item can be removed from a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $item->removeFromContainer($container);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});
