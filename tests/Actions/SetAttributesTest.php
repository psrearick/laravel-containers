<?php

use Psrearick\Containers\Facades\Containers;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('Attribute values can be increased on existing container item', function () {
    $totals = Containers::getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add(['quantity'  => 5.0, 'value' => 1.5])
        ->set(['quantity'  => 7.0, 'value' => 2.5])
        ->getTotals();

    $this->assertEquals(7, $totals['quantity']);
    $this->assertEquals(12.5, $totals['value']);
});

test('Attribute values can be decreased on existing container item', function () {
    $totals = Containers::getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )
        ->add(['quantity'  => 5.0, 'value' => 1.5])
        ->set(['quantity'  => 3.0, 'value' => 2.5])
        ->getTotals();

    $this->assertEquals(3, $totals['quantity']);
    $this->assertEquals(2.5, $totals['value']);
});
