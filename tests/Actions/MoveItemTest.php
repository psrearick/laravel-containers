<?php

use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Actions\MoveItem;
use Psrearick\Containers\Containers;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('an item cannot be removed from a container that it is not currently in', function () {
    $container    = Container::factory()->create();
    $newContainer = Container::factory()->create();
    $item         = Item::factory()->create();

    $this->expectException(ContainerItemNotFoundException::class);
    app(MoveItem::class)->execute($container, $item, $newContainer);
});

test('an item can move to a different location', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    $newContainer = Container::factory()->create();

    app(MoveItem::class)->execute(
        $instance->getContainer(),
        $instance->getItem(),
        $newContainer
    );

    $totals = app(GetContainerItemTotals::class)->execute($newContainer, $instance->getItem());

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(7.5, $totals['value']);

    $this->expectException(ContainerItemNotFoundException::class);
    app(GetContainerItemTotals::class)->execute($instance->getContainer(), $instance->getItem());
});

test('a non-summarized item can move to a different location', function () {
    $instance = app(Containers::class)->getInstance(
        ContainerNotSummarized::factory()->create(),
        ItemNotSummarized::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    $newContainer = ContainerNotSummarized::factory()->create();

    app(MoveItem::class)->execute(
        $instance->getContainer(),
        $instance->getItem(),
        $newContainer
    );

    $totals = app(GetContainerItemTotals::class)->execute($newContainer, $instance->getItem());

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(7.5, $totals['value']);

    $this->expectException(ContainerItemNotFoundException::class);
    app(GetContainerItemTotals::class)->execute($instance->getContainer(), $instance->getItem());
});
