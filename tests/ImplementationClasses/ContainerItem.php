<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsSummarized;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;
use Psrearick\Containers\Contracts\Summarized;

/**
 * @property float $quantity
 * @property float $value
 */
class ContainerItem extends Pivot implements ContainerItemContract, Summarized
{
    use IsSummarized;

    public $incrementing = true;

    protected $casts = [
        'quantity'  => 'float',
        'value'     => 'float',
    ];

    public function computations() : array
    {
        return [
            'quantity'  => Sum::class,
            'value'     => Sum::class,
        ];
    }

    public function summaryClass() : string
    {
        return ContainerItemSummary::class;
    }
}
