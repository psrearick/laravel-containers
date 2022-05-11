<?php

use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerItem;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an item can be added to a container', function () {
    Event::fake(ContainerItemWasUpdated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $container->receiveItem($item, [
        'quantity'  => 5,
        'value'     => 1.5,
    ]);

    /** @var ContainerItem $containerItem */
    $containerItem = $item->containerItem($container)->fresh();

    $this->assertEquals(5, optional($containerItem)->quantity);
    $this->assertEquals(1.5, optional($containerItem)->value);

    Event::assertDispatched(
        ContainerItemWasUpdated::class,
        static function (ContainerItemWasUpdated $event) use ($containerItem) {
            return $event->containerItem->id === $containerItem->id;
        }
    );
});
