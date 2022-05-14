<?php

use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('the class returns the correct total for the container', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(2.5, $totals['value']);

    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(5, $totals['value']);

    /** @var Item $item */
    $item2 = Item::factory()->create();
    $item2->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals2 = app(GetContainerItemTotals::class)->execute($container, $item2);

    $this->assertEquals(5, $totals2['quantity']);
    $this->assertEquals(2.5, $totals2['value']);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(5, $totals['value']);
});

test('the class returns the correct total for the non-summarized container', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(2.5, $totals['value']);

    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(5, $totals['value']);

    /** @var ItemNotSummarized $item */
    $item2 = ItemNotSummarized::factory()->create();
    $item2->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);

    $totals2 = app(GetContainerItemTotals::class)->execute($container, $item2);

    $this->assertEquals(5, $totals2['quantity']);
    $this->assertEquals(2.5, $totals2['value']);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(10, $totals['quantity']);
    $this->assertEquals(5, $totals['value']);
});
