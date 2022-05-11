<?php

use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

it('updates new container item attributes', function () {
    Event::fake(ContainerItemWasUpdated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item, [
        'quantity'  => 5,
        'value'     => 1.5,
    ]);

    $containerItem = $item->containerItem($container);

    $this->assertEquals(5, $containerItem->quantity);
    $this->assertEquals(1.5, $containerItem->value);

    ray($containerItem->id);

    Event::assertDispatched(
        ContainerItemWasUpdated::class,
        static function (ContainerItemWasUpdated $event) use ($containerItem) {
            return $event->containerItem->id === $containerItem->id;
        }
    );
});
