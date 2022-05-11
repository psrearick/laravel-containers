<?php

use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted when a container receives an item', function () {
    Event::fake(ContainerItemWasCreated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = ['quantity' => 1];

    $container->receiveItem($item, $attributes);

    Event::assertDispatched(
        ContainerItemWasCreated::class,
        static function (ContainerItemWasCreated $event) use ($container, $item, $attributes) {
            return $event->container->id === $container->id
                && $event->item->id === $item->id
                && $event->attributes['quantity'] === $attributes['quantity'];
        }
    );
});

test('an event is emitted when an item is added to a container', function () {
    Event::fake(ContainerItemWasCreated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = ['quantity' => 1];

    $item->addToContainer($container, $attributes);

    Event::assertDispatched(
        ContainerItemWasCreated::class,
        static function (ContainerItemWasCreated $event) use ($container, $item, $attributes) {
            return $event->container->id === $container->id
                && $event->item->id === $item->id
                && $event->attributes['quantity'] === $attributes['quantity'];
        }
    );
});


