<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Events\ContainerWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;

it('emits an event when a container is created', function () {
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

//it('creates a new container summary when a container create event listener is triggered',
//    function () {
//        /** @var Container $container */
//        $container = Container::factory()->create([
//            'model' => null,
//            'uuid'  => null,
//        ]);
//
//        $summary = $container->summary();
//
//        $this->assertCount(0, $summary->quantity);
//    }
//);

//it('creates a new container summary when a container create event is triggered',
//    function () {}
//);
