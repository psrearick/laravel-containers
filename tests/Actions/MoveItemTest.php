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
    $instance->getTotals();
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
    $instance->getTotals();
});

//test('moving a nested item updates the parents summary', function () {
//    $instance = app(Containers::class)->getInstance(
//        Container::factory()->create(),
//        Container::factory()->create(),
//    )->add([]);
//
//    $newInstance = app(Containers::class)->getInstance(
//        Container::factory()->create(),
//        Container::factory()->create(),
//    )->add([]);
//
//    $instance2 = app(Containers::class)->getInstance(
//        $instance->getItem(),
//        Item::factory()->create()
//    )->add([
//        'quantity'  => 5.0,
//        'value'     => 1.5,
//    ]);
//
//    // Verify totals before move
//    $instanceTotals = app(GetContainerItemTotals::class)->execute($instance->getContainer(), $instance->getItem());
//    $instance2Totals = app(GetContainerItemTotals::class)->execute($instance2->getContainer(), $instance2->getItem());
//    $newInstanceTotals = app(GetContainerItemTotals::class)->execute($newInstance->getContainer(), $newInstance->getItem());
//    $this->assertEquals(7.5, $instanceTotals['value']);
//    $this->assertEquals(5, $instance2Totals['quantity']);
//    $this->assertEquals(7.5, $instance2Totals['value']);
//    $this->assertEquals(0, $newInstanceTotals['value']);
//
//    // move
//    app(MoveItem::class)->execute(
//        $instance2->getContainer(),
//        $instance2->getItem(),
//        $newInstance->getItem()
//    );
//
//    // assert totals after move
//    $instanceTotals = app(GetContainerItemTotals::class)->execute($instance->getContainer(), $instance->getItem());
//    $newInstanceTotals = app(GetContainerItemTotals::class)->execute($newInstance->getContainer(), $newInstance->getItem());
//
////    ray($instanceTotals);
////    ray($newInstanceTotals);
//
//    $service = app(\Psrearick\Containers\Services\ContainerItemManagerService::class)
//        ->service($instance->getContainer(), $instance->getItem());
//    ray($service);
////    ray($service->item()->load('containerItems.item'));
//
////    $service2 = app(\Psrearick\Containers\Services\ContainerItemManagerService::class)
////        ->service($newInstance->getContainer(), $newInstance->getItem());
////    ray($service2);
////    $service2 = app(\Psrearick\Containers\Services\ContainerItemManagerService::class)
////        ->service($newInstance->getContainer(), $newInstance->getItem());
//
//    $this->assertEquals(0, $instanceTotals['value']);
//    $this->assertEquals(7.5, $newInstanceTotals['value']);
//
//    // The old location should be empty
//    $this->expectException(ContainerItemNotFoundException::class);
//    app(GetContainerItemTotals::class)->execute($instance2->getContainer(), $instance2->getItem());
//});
//
//test('items in different locations can be merged', function () {});
