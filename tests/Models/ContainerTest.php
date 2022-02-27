<?php

use Psrearick\Containers\Models\Container;

it('created a container with a uuid and model class', function () {
    $container = Container::factory()->create();
    $this->assertNotNull($container->uuid);
    $this->assertEquals(Container::class, $container->model);
});
