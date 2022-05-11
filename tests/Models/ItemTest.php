<?php

use Psrearick\Containers\Tests\ImplementationClasses\Item;

test('an item can be created', function () {
    $data = ['name' => 'item'];
    $item = Item::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});
