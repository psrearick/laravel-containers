<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Actions\CreateItem;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Models\Item;

it('can create an item from an action', function () {
    $item = app(CreateItem::class)->execute(
        Item::class,
        [
            'name'          => 'first item',
            'description'   => 'this is the first item',
        ]
    );

    $this->assertEquals('first item', $item->name);
    $this->assertNotNull($item->uuid);
});

it('will dispatch an event when an item is created from an action', function () {
    Event::fake([
        ItemWasCreated::class,
    ]);

    app(CreateItem::class)->execute(
        Item::class,
        [
            'name'          => 'first item',
            'description'   => 'this is the first item',
        ]
    );

    Event::assertDispatched(ItemWasCreated::class);
});
