<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

it('emits an event when an item is created', function () {
    Event::fake(ItemWasCreated::class);

    $item = Item::factory()->create();

    Event::assertDispatched(
        ItemWasCreated::class,
        static function (ItemWasCreated $event) use ($item) {
            return $event->item->id === $item->id;
        }
    );
});
