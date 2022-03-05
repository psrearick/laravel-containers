<?php

namespace Psrearick\Containers\Tests\Models;

use Psrearick\Containers\Tests\ImplementationClasses\Item;

it('creates an item with a uuid and model class', function () {
    /** @var Item $item */
    $item = Item::factory()->create([
        'uuid'  => null,
        'model' => null,
    ]);

    $this->assertNotNull($item->uuid);
    $this->assertEquals(Item::class, $item->model);
});
