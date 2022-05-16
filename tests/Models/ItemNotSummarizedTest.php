<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

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

test('an non-summarized item can be removed from a container', function () {
    /** @var ContainerNotSummarized $container */
    $container = ContainerNotSummarized::factory()->create();

    /** @var ItemNotSummarized $item */
    $item = ItemNotSummarized::factory()->create();
    $item->addToContainer($container, ['quantity' => 5]);

    $item->removeFromContainer($container);

    $this->expectException(ContainerItemNotFoundException::class);

    app(GetContainerItemTotals::class)->execute($container, $item);
});
