<?php

use Psrearick\Containers\Domain\Containers\Models\Container;
use Psrearick\Containers\Facades\Containers;

it('created a container with a uuid and model class', function () {
    /** @var Container $container */
    $container = Container::factory()->create();
    $this->assertNotNull($container->uuid);
    $this->assertEquals(Container::class, $container->model);
});

//it('has a facade', function () {
//    Containers::test();
//});
