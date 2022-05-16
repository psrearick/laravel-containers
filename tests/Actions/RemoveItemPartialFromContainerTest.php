<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Actions\RemoveItemPartialFromContainer;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('an item can remove some of its quantity from a container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 5]);
    app(RemoveItemPartialFromContainer::class)->execute($container, $item, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertDatabaseCount('container_items', 2);
    $this->assertEquals(3, $totals['quantity']);
});

test('removing a partial quantity from a non-summarized container does not create additional container item records', function () {
    /** @var Container $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var Item $item */
    $item = ItemNotSummarized::factory()->create();

    app(AddItemToContainer::class)->execute($container, $item, ['quantity' => 5]);

    app(RemoveItemPartialFromContainer::class)->execute($container, $item, ['quantity' => 2]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
    $this->assertEquals(3, $totals['quantity']);
});

test('non-quantity fields can be updated when removing partial quantities', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $item->removePartial($container, ['quantity' => 2, 'value' => 1]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1, $totals['value']);
});
