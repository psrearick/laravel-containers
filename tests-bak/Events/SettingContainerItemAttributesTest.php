<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Containers;
use Psrearick\Containers\Events\SettingContainerItemAttributes;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted to set container item attributes', function () {
    Event::fake(SettingContainerItemAttributes::class);

    app(Containers::class)->getInstance(
        Container::factory()->create(),
        Item::factory()->create()
    )->set([
        'quantity'  => 5.0,
        'value'     => 1.5,
    ]);

    Event::assertDispatched(
        SettingContainerItemAttributes::class
    );
});
