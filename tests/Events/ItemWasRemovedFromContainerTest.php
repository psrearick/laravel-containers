<?php

namespace Psrearick\Containers\Tests\Events;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Events\ItemWasRemovedFromContainer;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted when a container discards an item', function () {
    Event::fake(ItemWasRemovedFromContainer::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = ['quantity' => 1];

    $container->receiveItem($item, $attributes);

    $container->discardItem($item);

    Event::assertDispatched(ItemWasRemovedFromContainer::class,
        static function (ItemWasRemovedFromContainer $event) use ($container, $item) {
            return $event->container->id === $container->id && $event->item->id === $item->id;
        }
    );
});

test('an event is emitted when an item is removed from a container', function () {
    Event::fake(ItemWasRemovedFromContainer::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = ['quantity' => 1];

    $container->receiveItem($item, $attributes);

    $item->removeFromContainer($container);

    Event::assertDispatched(ItemWasRemovedFromContainer::class,
        static function (ItemWasRemovedFromContainer $event) use ($container, $item) {
            return $event->container->id === $container->id && $event->item->id === $item->id;
        }
    );
});
