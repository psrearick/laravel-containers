<?php

use Psrearick\Containers\Containers;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a summary is created for new container items with attributes', function () {
    $attributes = [
        'quantity'  => 5.0,
        'value'     => 2,
    ];

    $summary = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add($attributes)
        ->getSummary();

    $this->assertNotNull($summary);
    $this->assertDatabaseCount('container_item_summaries', 1);
    $this->assertEquals($attributes['quantity'], $summary->quantity);
    $this->assertEquals($attributes['quantity'] * $attributes['value'], $summary->value);
});

test('a summary is updated for new container items that match existing container-item ids', function () {
    $attributes = [
        'quantity'  => 5.0,
        'value'     => 2,
    ];

    $summary = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add($attributes)
        ->add($attributes)
        ->add($attributes)
        ->getSummary();

    $this->assertEquals($attributes['quantity'] * 3, $summary->quantity);
    $this->assertEquals($attributes['value'] * 15, $summary->value);
    $this->assertDatabaseCount('container_item_summaries', 1);
});
