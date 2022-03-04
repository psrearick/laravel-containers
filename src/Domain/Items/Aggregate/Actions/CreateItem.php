<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Actions;

use Psrearick\Containers\Contracts\Item;

class CreateItem
{
    public function execute(string $class = '', array $data = []) : Item
    {
        return app($class ?: config('containers.default_item'))->create($data);
    }
}
