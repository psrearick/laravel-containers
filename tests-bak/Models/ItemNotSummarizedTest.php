<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('a non-summarized item can be created', function () {
    $data = ['name' => 'item'];
    $item = ItemNotSummarized::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});

test('a non-summarized item can be added to a container', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();

    $item->addToContainer($container, ['quantity' => 1]);

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
});

test('a non-summarized item can remove part of is container quantity', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5]);
    $item->removePartial($container, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
});

test('a non-summarized item can be removed from a container', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $item->removeFromContainer($container);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});
