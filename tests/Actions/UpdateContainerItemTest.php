<?php

use Psrearick\Containers\Actions\UpdateContainerItem;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerItem;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('A new container item can be given a quantity', function () {
    Event::fake(ContainerItemWasCreated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    $item->addToContainer($container, $attributes);
    $item->addToContainer($container, $attributes);

    /** @var ContainerItem $containerItem */
    $containerItem = app(UpdateContainerItem::class)->execute($container, $item, $attributes);

    $this->assertEquals($attributes['quantity'], optional($containerItem)->quantity);
    $this->assertEquals($attributes['value'], optional($containerItem)->value);
});
