<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Item;
use Psrearick\Containers\Tests\ImplementationClasses\Outer;

test('a container can be contained by a different container model', function () {
    $outer     = Outer::factory()->create();
    $container = Container::factory()->create();
    $item      = Item::factory()->create();

    $attributes = [
        'quantity'  => 5.0,
    ];

    $item->addToContainer($container, $attributes);
    $container->addToContainer($outer);

    $containerForItem = $item->getLatestContainerOfType(get_class($container));

    $this->assertEquals($container->id, $containerForItem->id);

    $containerForContainer = $container->getLatestContainerOfType(get_class($outer));

    $this->assertEquals($containerForItem->id, $containerForContainer->id);
});

test('a container can be nested inside a container of the same model', function () {
    /** @var Container $parentContainer */
    $parentContainer = Container::factory()->create();

    /** @var Container $childContainer */
    $childContainer = Container::factory()->create();

    $childContainer->addToContainer($parentContainer);

    $this->assertEquals($parentContainer->id, $childContainer->getLatestContainerOfType(Container::class)->id);
    $this->assertNull($parentContainer->getLatestContainerOfType(Container::class));

    $this->assertEquals($childContainer->id, $parentContainer->getLatestItemOfType(Container::class)->id);
});
