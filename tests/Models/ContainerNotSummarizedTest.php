<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('a container can be created', function () {
    $data      = ['name' => 'container'];
    $container = ContainerNotSummarized::factory()->create($data);

    $this->assertDatabaseHas($container, $data);
});

test('a container can receive an item', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();

    $container->receiveItem($item, ['quantity' => 1]);

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
});

test('a non-summarized container can remove part of its children quantity', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5]);
    $container->discardPartialItem($item, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
});

test('a non-summarized container can discard an item', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $container->discardItem($item);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});
