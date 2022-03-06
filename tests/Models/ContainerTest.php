<?php

use Psrearick\Containers\Tests\ImplementationClasses\Container;

it('created a container with a uuid and model class', function () {
    /** @var Container $container */
    $container = Container::factory()->create([
        'uuid'  => null,
        'model' => null,
    ]);

    $this->assertNotNull($container->uuid);
    $this->assertEquals(Container::class, $container->model);
});
