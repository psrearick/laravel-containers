<?php

namespace Psrearick\Containers\Tests\ImplementationClasses\Traits;

use Psrearick\Containers\Computations\AddQuantityMultiple;
use Psrearick\Containers\Computations\Subtract;
use Psrearick\Containers\Computations\SubtractQuantityMultiple;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Tests\Computations\CurrentValue;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

trait ItemComputation
{
    protected array $itemComputations = [
        Item::class => [
            'current' => [
                'add'       => CurrentValue::class,
                'remove'    => CurrentValue::class,
            ],
            'quantity' => [
                'add'       => Sum::class,
                'remove'    => Subtract::class,
            ],
            'value'     => [
                'add'       => AddQuantityMultiple::class,
                'remove'    => SubtractQuantityMultiple::class,
            ],
        ],
    ];
}
