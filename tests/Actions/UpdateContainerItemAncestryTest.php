<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Containers;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a nested container item summary can be generated', function () {
    /** @var Container $parentContainer */
    $parentContainer = Container::factory()->create();

    /** @var Container $childContainer */
    $childContainer = Container::factory()->create();

    app(AddItemToContainer::class)
        ->execute($parentContainer, $childContainer);

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    app(AddItemToContainer::class)
        ->execute($childContainer, $item, $attributes);

    $containerItem        = $childContainer->getContainerItem($item, 'container');
    $containerItemSummary = $containerItem->{$containerItem->summarizedBy()};

    $parentItem        = $parentContainer->getContainerItem($childContainer, 'container');
    $parentItemSummary = $parentItem->{$parentItem->summarizedBy()};

    $this->assertEquals($attributes['quantity'] * $attributes['value'], $containerItemSummary->value);
    $this->assertEquals($attributes['quantity'] * $attributes['value'], $parentItemSummary->value);
});

test('a parent container is updated when its children are updated', function () {
    $instance = app(Containers::class)->getInstance(
        Container::factory()->create(),
        Container::factory()->create()
    )
        ->add([]);

    $childInstance = app(Containers::class)->getInstance(
        $instance->getItem(),
        Item::factory()->create()
    )
        ->add(['quantity'  => 5.0, 'value' => 1.5])
        ->set(['quantity'  => 2.0, 'value' => 1.5]);

    $this->assertEquals(3, $childInstance->getSummary()->value);
    $this->assertEquals(3, $instance->getSummary()->value);
});

//test('a parent container can have a total of all children values', function () {
//});

# ancestry is updated when removing, add, updating a container item
