<?php

use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemSummaryWasUpdated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerItem;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerItemSummary;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an event is emitted when a container summary is updated', function () {
    Event::fake(ContainerItemSummaryWasUpdated::class);

    /** @var Container $container */
    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = ['quantity' => 1.0];

    $container->receiveItem($item, $attributes);

    /** @var ContainerItem $containerItem */
    $containerItem = $container->getContainerItem($item, 'container');

    app(UpdateContainerItemSummary::class)->execute($container, $item);

    Event::assertDispatched(
        ContainerItemSummaryWasUpdated::class,
        static function (ContainerItemSummaryWasUpdated $event) use ($attributes) {
            /** @var ContainerItemSummary $summary */
            $summary = $event->summary;

            return $summary->quantity === $attributes['quantity'];
        }
    );
});
