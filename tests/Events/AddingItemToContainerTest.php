<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Containers;
use Psrearick\Containers\Events\AddingItemToContainer;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted to add an item to a container', function () {
    Event::fake(AddingItemToContainer::class);

    app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->add([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    Event::assertDispatched(
        AddingItemToContainer::class
    );
});
