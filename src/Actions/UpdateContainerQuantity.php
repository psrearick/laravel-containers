<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Models\Base\Container;

class UpdateContainerQuantity
{
    public function execute(string $class = '', array $data = []) : Container
    {
        return app($class ?: config('containers.default_container'))->create($data);
    }
}
