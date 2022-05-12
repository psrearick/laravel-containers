<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;
use Psrearick\Containers\Tests\ImplementationClasses\Outer;

test('an outer can receive a container', function () {
    $outer = Outer::factory()->create();
    $container = Container::factory()->create();

    $outer->receiveItem($container);

    $this->assertDatabaseCount('container_outers', 1);
});
