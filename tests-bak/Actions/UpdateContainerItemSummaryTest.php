<?php

use Psrearick\Containers\Containers;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a new container item summary can be generated', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    $this->assertEquals(7.5, $instance->getSummary()->value);
});

test('a new container item summary can be updated', function () {
    $summary = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ])->set([
        'quantity'  => 3.0,
        'value'     => 2,
    ])->getSummary();

    $this->assertEquals(3.5, optional($summary)->value);
    $this->assertEquals(6, optional($summary)->current);
});
