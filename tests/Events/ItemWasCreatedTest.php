<?php

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Domain\Items\Aggregate\Listeners\AddItem;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

it('emits an event when an item is created', function () {
    Event::fake(ItemWasCreated::class);

    $item = Item::factory()->create();

    Event::assertDispatched(
        ItemWasCreated::class,
        static function (ItemWasCreated $event) use ($item) {
            return $event->item->uuid === $item->uuid;
        }
    );
});

it('creates a new container item when an item event listener is triggered with a quantity', function () {
    Event::fake(ItemWasCreated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create([
        'uuid'          => null,
        'quantity'      => 5,
        'containers'    => [
            'container' => [
                'class' => Container::class,
                'uuid'  => $container->uuid,
            ],
        ],
    ]);

    (new AddItem())->handle(
        new ItemWasCreated($item)
    );

    $this->assertCount(1, $item->containerItems);
    $this->assertCount(1, $item->containers());
    $this->assertEquals($container->uuid, $item->containers()->first()->uuid);
});

it('creates a new container item when an item is created with a quantity', function () {
    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create([
        'uuid'          => null,
        'quantity'      => 5,
        'containers'    => [
            'container' => [
                'class' => Container::class,
                'uuid'  => $container->uuid,
            ],
        ],
    ]);

    $this->assertCount(1, $item->containerItems);
    $this->assertCount(1, $item->containers());
    $this->assertEquals($container->uuid, $item->containers()->first()->uuid);
});
