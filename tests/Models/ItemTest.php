<?php

namespace Psrearick\Containers\Tests\Models;

use Psrearick\Containers\Models\Item;

it('created an item with a uuid, container, and model class', function () {
    $item = Item::factory()->create();
    $this->assertNotNull($item->uuid);
    $this->assertEquals(Item::class, $item->model);
});
