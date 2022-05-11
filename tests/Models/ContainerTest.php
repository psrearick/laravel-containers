<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;

test('a container can be created', function () {
    $data      = ['name' => 'container'];
    $container = Container::factory()->create($data);

    $this->assertDatabaseHas($container, $data);
});
