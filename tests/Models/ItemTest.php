<?php

use Psrearick\Containers\Tests\ImplementationClasses\Item;

it('creates an item', function () {
    $data = ['name' => 'item'];
    $item = Item::factory()->create($data);

    $this->assertDatabaseHas($item, $data);
});
