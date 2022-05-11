<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;

it('creates a container', function () {
    $data      = ['name' => 'container'];
    $container = Container::factory()->create($data);

    $this->assertDatabaseHas($container, $data);
});
