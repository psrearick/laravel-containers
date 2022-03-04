<?php

namespace Psrearick\Containers\Domain\Containers\Aggregate\Actions;

use Psrearick\Containers\Domain\Containers\Models\Base\Container;

class CreateContainer
{
    public function execute(string $class = '', array $data = []) : Container
    {
        return app($class ?: config('containers.default_container'))->create($data);
    }
}
