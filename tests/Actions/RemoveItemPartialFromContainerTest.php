<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('non-quantity fields can be updated when removing partial quantities', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    app(AddItemToContainer::class)
        ->execute($container, $item, ['quantity' => 5, 'value' => 2.5]);

    $item->removePartial($container, ['quantity' => 2, 'value' => 1]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1, $totals['value']);
});
