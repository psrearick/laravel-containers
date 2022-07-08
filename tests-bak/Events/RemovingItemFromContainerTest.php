<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Containers;
use Psrearick\Containers\Events\RemovingItemFromContainer;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted to remove an item to from container', function () {
    Event::fake(RemovingItemFromContainer::class);

    app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ])->remove();

    Event::assertDispatched(
        RemovingItemFromContainer::class
    );
});
