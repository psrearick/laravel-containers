<?php

use Psrearick\Containers\Facades\Containers;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

test('an item can remove some of its quantity from a container', function () {
    $totals = Containers::getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add(['quantity' => 5])
        ->remove(['quantity' => 2])
        ->getTotals();

    $this->assertDatabaseCount('container_items', 2);
    $this->assertEquals(3, $totals['quantity']);
});

test('removing a partial quantity from a non-summarized container does not create additional container item records', function () {
    $totals = Containers::getInstance(
        ContainerNotSummarized::factory()->create(),
        ItemNotSummarized::factory()->create()
    )
        ->add(['quantity' => 5])
        ->remove(['quantity' => 2])
        ->getTotals();

    $this->assertDatabaseCount('container_item_not_summarizeds', 1);
    $this->assertEquals(3, $totals['quantity']);
});

test('non-quantity fields are updated when removing partial quantities', function () {
    $totals = Containers::getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add(['quantity' => 5, 'value' => 2.5])
        ->remove(['quantity' => 2, 'value' => 2.5])
        ->getTotals();

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(7.5, $totals['value']);
});

test('non-quantity fields can be changed when removing partial quantities', function () {
    $totals = Containers::getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add(['quantity' => 5, 'value' => 2.5])
        ->remove(['quantity' => 2, 'value' => 2])
        ->getTotals();

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(8.5, $totals['value']);
});
