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
        'value'     => 1.5,
    ];

    $container->receiveItem($item, $attributes);

    $itemContainerItemSummary      = $item->containerItemSummary->first();
    $containerContainerItemSummary = $container->containerItemSummary->first();

    $this->assertEquals($attributes['quantity'], $itemContainerItemSummary->quantity);
    $this->assertEquals($attributes['value'], $itemContainerItemSummary->value);
    $this->assertNotNull($itemContainerItemSummary);
    $this->assertEquals(optional($itemContainerItemSummary)->id, optional($containerContainerItemSummary)->id);
    $this->assertDatabaseCount('container_item_summaries', 1);
});

test('a summary is updated for new container items that match existing container-item ids', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    $container->receiveItem($item, $attributes);
    $container->receiveItem($item, $attributes);
    $container->receiveItem($item, $attributes);

    $itemContainerItemSummary      = $item->containerItemSummary->first();
    $containerContainerItemSummary = $container->containerItemSummary->first();

    $this->assertEquals($attributes['quantity'] * 3, $itemContainerItemSummary->quantity);
    $this->assertEquals($attributes['value'] * 3, $itemContainerItemSummary->value);
    $this->assertNotNull($itemContainerItemSummary);
    $this->assertEquals(optional($itemContainerItemSummary)->id, optional($containerContainerItemSummary)->id);
    $this->assertDatabaseCount('container_item_summaries', 1);
});
