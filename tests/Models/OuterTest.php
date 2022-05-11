<?php

use Psrearick\Containers\Tests\ImplementationClasses\Outer;

it('creates an outer object', function () {
    $data = ['name' => 'outer'];
    $item = Outer::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});
