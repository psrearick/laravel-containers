<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

//use Psrearick\Containers\Domain\Items\Models\Item;

it('emits an event when an item is created',  function () {
    Event::fake(ItemWasCreated::class);

    $item = Item::factory()->create();

    Event::assertDispatched(ItemWasCreated::class, function (ItemWasCreated $event) use ($item) {
        return $event->item->uuid === $item->uuid;
    });
});

//it('updates the container item quantity when an item event is triggered', function () {
//    /** @var Item $item */
//    $item = Item::factory()->create();
//    $uuid = $item->uuid;
//
//    (new AddItemToContainer())->handle(
//        new ItemWasCreated($item)
//    );
//
//    $this->assertNotEquals($uuid, $item->fresh()->uuid);
//});

it('updates the container item quantity when an item is created', function () {
    /** @var Container $container */
    $container = Container::factory()->create();
    $container2 = Container::factory()->create();

    $uuid = Str::uuid()->toString();

    /** @var Item $item */
    $item = Item::factory()->create([
        'uuid'          => $uuid,
        'quantity'      => 5,
        'containers'    => [
            'container' => [
                'class' => Container::class,
                'uuid'  => $container->uuid,
            ],
        ],
    ]);

    $item->containerItems()->make(['quantity' => 2])
        ->containerable()
        ->associate($container2)
        ->save();

    ray(Item::factory()->create());

//    ray($uuid, $item);
//    $this->assertNotEquals($uuid, $item->fresh()->uuid);
});
