<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Actions\SetContainerItemAttributes;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('Attribute values can be increased on existing container item', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    app(AddItemToContainer::class)->execute($container, $item, $attributes);

    $attributes = [
        'quantity'  => 7.0,
        'value'     => 2.5,
    ];

    app(SetContainerItemAttributes::class)->execute($container, $item, $attributes);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(7, $totals['quantity']);
    $this->assertEquals(2.5, $totals['value']);
});
