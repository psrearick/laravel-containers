<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a summary is created for new container items with attributes', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 2,
    ];

    $container->receiveItem($item, $attributes);

    $itemContainerItemSummary      = $container->containerItems->last()->containerItemSummary;

    $this->assertEquals($attributes['quantity'], $itemContainerItemSummary->quantity);
    $this->assertEquals($attributes['quantity'] * $attributes['value'], $itemContainerItemSummary->value);
    $this->assertNotNull($itemContainerItemSummary);
    $this->assertDatabaseCount('container_item_summaries', 1);
});

test('a summary is updated for new container items that match existing container-item ids', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 2,
    ];

    $container->receiveItem($item, $attributes);
    $container->receiveItem($item, $attributes);
    $container->receiveItem($item, $attributes);

    $summary = $item->getContainerItem($container, 'item')->containerItemSummary;

    $this->assertEquals($attributes['quantity'] * 3, $summary->quantity);
    $this->assertEquals($attributes['value'] * 15, $summary->value);
    $this->assertDatabaseCount('container_item_summaries', 1);
});
