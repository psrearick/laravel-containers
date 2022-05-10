<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot as Base;

class ItemsAggregateRoot extends Base
{
    public function computationFields(): array
    {
        return array_merge([
            'value' => Sum::class,
        ],
        parent::computationFields());
    }
}
