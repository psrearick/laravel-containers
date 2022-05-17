<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('the class returns the correct total for the container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    Item::factory()->create(); // this is just to offset the ids so the container and item are not both 1

    /** @var Item $item */
    $item = Item::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(12.5, $totals['value']);

    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(25, $totals['value']);

    /** @var Item $item */
    $item2 = Item::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item2, ['quantity' => 5, 'value' => 2.5]);

    $totals2 = app(GetContainerItemTotals::class)->execute($container, $item2);

    $this->assertEquals(5, $totals2['quantity']);
    $this->assertEquals(12.5, $totals2['value']);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(25, $totals['value']);
});

test('the class returns the correct total for the non-summarized container', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    ray($totals);

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(12.5, $totals['value']);

    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(25, $totals['value']);

    /** @var ItemNotSummarized $item */
    $item2 = ItemNotSummarized::factory()->create();
    app(AddItemToContainer::class)
        ->execute($container, $item2, ['quantity' => 5, 'value' => 2.5]);

    $totals2 = app(GetContainerItemTotals::class)->execute($container, $item2);

    $this->assertEquals(5, $totals2['quantity']);
    $this->assertEquals(12.5, $totals2['value']);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(25, $totals['value']);
});
