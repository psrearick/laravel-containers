<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Models\Base\Item;

class CreateItem
{
    public function execute(string $class = '', array $data = []) : Item
    {
        return app($class ?: config('containers.default_item'))->create($data);
    }
}
