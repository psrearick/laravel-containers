<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Listeners\AddItemToContainer;
use Psrearick\Containers\Models\Item;

it('emits an event when an item is created',  function () {
    Event::fake();

    $item = Item::factory()->create();

    Event::assertDispatched(ItemWasCreated::class, function (ItemWasCreated $event) use ($item) {
        return $event->item->uuid === $item->uuid;
    });
});

it('updates the container item quantity when an item event is triggered', function () {
    $item = Item::factory()->create();
    $uuid = $item->uuid;

    (new AddItemToContainer())->handle(
        new ItemWasCreated($item)
    );

    $this->assertNotEquals($uuid, $item->fresh()->uuid);
});

it('updates the container item quantity when an item is created', function () {
    $uuid = Str::uuid()->toString();
    $item = Item::factory()->create(['uuid' => $uuid]);
    $this->assertNotEquals($uuid, $item->fresh()->uuid);
});
