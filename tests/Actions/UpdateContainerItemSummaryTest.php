<?php

use Psrearick\Containers\Actions\AddItemToContainer;
use Psrearick\Containers\Actions\UpdateContainerItemSummary;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('a new container item summary can be generated', function () {
    Event::fake(ContainerItemWasUpdated::class);

    $container = Container::factory()->create();

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    app(AddItemToContainer::class)
        ->execute($container, $item, $attributes);

    $containerItem = $container->getContainerItem($item, 'container');

    app(UpdateContainerItemSummary::class)->execute($containerItem);

    $summary = $containerItem->{$containerItem->summarizedBy()};

    $this->assertEquals($attributes['value'], $summary->value);
});

test('a nested container item summary can be generated', function () {
    /** @var Container $parentContainer */
    $parentContainer = Container::factory()->create();

    /** @var Container $childContainer */
    $childContainer = Container::factory()->create();

    app(AddItemToContainer::class)
        ->execute($parentContainer, $childContainer);

    /** @var Item $item */
    $item = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
        'value'     => 1.5,
    ];

    app(AddItemToContainer::class)
        ->execute($childContainer, $item, $attributes);

    $containerItem        = $childContainer->getContainerItem($item, 'container');
    $containerItemSummary = $containerItem->{$containerItem->summarizedBy()};

    $parentItem        = $parentContainer->getContainerItem($childContainer, 'container');
    $parentItemSummary = $parentItem->{$parentItem->summarizedBy()};

    $this->assertEquals($attributes['value'], $containerItemSummary->value);
    $this->assertEquals($attributes['value'], $parentItemSummary->value);
});
