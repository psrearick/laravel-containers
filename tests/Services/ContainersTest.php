<?php

use Psrearick\Containers\Containers;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('the service can add an item to a container', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    $this->assertDatabaseCount('container_items', 1);
    $this->assertEquals(5, optional($instance->getItem())->getContainerItem($instance->getContainer())->quantity);
});

test('the service can remove some of an item from a container', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ])->remove(['quantity' => 2]);

    $this->assertDatabaseCount('container_items', 2);
    $this->assertEquals(3, $instance->getTotals()['quantity']);
});

test('the service can remove an item from a container', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ])->remove();

    $this->expectException(ContainerItemNotFoundException::class);
    $instance->getTotals();
});

test('the service can set container item attributes', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->set([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    $totals = $instance->getTotals();

    $this->assertEquals(5, $totals['quantity']);
    $this->assertEquals(7.5, $totals['value']);
});

// move item
// set
