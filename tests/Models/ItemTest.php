<?php

namespace Psrearick\Containers\Tests\Models;

use Psrearick\Containers\Models\Item;

it('creates an item with a uuid and model class', function () {
    /** @var Item $item */
    $item = Item::factory()->create();

    $this->assertNotNull($item->uuid);
    $this->assertEquals(Item::class, $item->model);
});
