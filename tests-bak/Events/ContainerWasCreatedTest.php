<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Events\ContainerWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;

test('an event is emitted when a container is created', function () {
    Event::fake(ContainerWasCreated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    Event::assertDispatched(
        ContainerWasCreated::class,
        static function (ContainerWasCreated $event) use ($container) {
            return $event->container->id === $container->id;
        }
    );
});
