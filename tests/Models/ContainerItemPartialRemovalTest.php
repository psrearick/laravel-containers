<?php

use Psrearick\Containers\Actions\GetContainerItemTotals;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an item can remove part of is container quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();
    $item->addToContainer($container, ['quantity' => 5, 'value' => 2.5]);
    $item->removePartial($container, ['quantity' => 2, 'value' => 1.25]);

    $totals = app(GetContainerItemTotals::class)->execute($container, $item);

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(1.25, $totals['value']);
});

test('an container can remove part of its children quantity', function () {});
