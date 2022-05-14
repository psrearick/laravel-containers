<?php

use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('an item can remove part of is container quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);
    $item->removePartial($container, ['quantity' => 2, 'value' => 1.25]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1.25, $totals['value']);
});

test('an container can remove part of its children quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);
    $container->discardPartialItem($item, ['quantity' => 2, 'value' => 1.25]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1.25, $totals['value']);
});

test('a non-summarized item can remove part of is container quantity', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);
    $item->removePartial($container, ['quantity' => 2, 'value' => 1.25]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1.25, $totals['value']);
});

test('a non-summarized container can remove part of its children quantity', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);
    $container->discardPartialItem($item, ['quantity' => 2, 'value' => 1.25]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1.25, $totals['value']);
});
