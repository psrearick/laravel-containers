<?php

use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

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

test('a container can discard an item', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $container->discardItem($item);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});

test('an non-summarized item can be removed from a container', function () {
    /** @var Container $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var Item $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $item->removeFromContainer($container);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});

test('a non-summarized container can discard an item', function () {
    /** @var Container $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var Item $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $container->discardItem($item);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});
