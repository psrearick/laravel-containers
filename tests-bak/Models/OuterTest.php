<?php

use Psrearick\Containers\Tests\ImplementationClasses\Outer;

test('an outer object can be created', function () {
    $data = ['name' => 'outer'];
    $item = Outer::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});
