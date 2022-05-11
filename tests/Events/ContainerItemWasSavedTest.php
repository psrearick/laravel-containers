<?php

//use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerItemWasSaved;
//use Psrearick\Containers\Tests\ImplementationClasses\Container;
//use Psrearick\Containers\Tests\ImplementationClasses\Item;

//it('emits an event when a container item is saved', function () {
//    Event::fake(ContainerItemWasSaved::class);
//
//    /** @var Container $container */
//    $container = Container::factory()->create();
//
//    /** @var Item $item */
//    $item = Item::factory()->create([
//        'uuid'          => null,
//        'quantity'      => 5,
//        'containers'    => [
//            'container' => [
//                'class' => Container::class,
//                'uuid'  => $container->uuid,
//            ],
//        ],
//    ]);
//
//    Event::assertDispatched(ContainerItemWasSaved::class);
//});

//it('updates a container summary when an item is created with a quantity', function () {
//    /** @var Container $container */
//    $container = Container::factory()->create();
//
//    /** @var Item $item */
//    $item = Item::factory()->create([
//        'uuid'          => null,
//        'quantity'      => 5,
//        'containers'    => [
//            'container' => [
//                'class' => Container::class,
//                'uuid'  => $container->uuid,
//            ],
//        ],
//    ]);
//
//    $container = $container->fresh();
//
//    $this->assertEquals(5, $container->containerSummary->quantity);
//    $this->assertEquals(5, $container->itemSummaries->where('item', '=', Item::class)->first()->quantity);
//});
