<?php

use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerItem;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted when an item is added to a container with attributes', function () {
    Event::fake(ContainerItemWasUpdated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    $container->receiveItem($item, $attributes);

    /** @var ContainerItem $containerItem */
    $containerItem = optional($item->containerItem($container))->refresh();

    Event::assertDispatched(
        ContainerItemWasUpdated::class,
        static function (ContainerItemWasUpdated $event) use ($containerItem, $attributes) {
            return $event->containerItem->id === $containerItem->id
                && $containerItem->quantity === $attributes['quantity']
                && $containerItem->value === $attributes['value'];
        }
    );
});

test('an event is not emitted when an item is added to a container without attributes', function () {
    Event::fake();

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item);

    Event::assertNotDispatched(
        ContainerItemWasUpdated::class,
    );
});
