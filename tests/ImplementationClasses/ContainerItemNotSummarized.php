<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Computations\AddQuantityMultiple;
use Psrearick\Containers\Computations\Subtract;
use Psrearick\Containers\Computations\SubtractQuantityMultiple;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Models\ContainerItem as Base;

/**
 * @property float $quantity
 * @property float $value
 */
class ContainerItemNotSummarized extends Base
{
    protected $casts = [
        'quantity'  => 'float',
        'value'     => 'float',
    ];

    public function computations(): array
    {
        return [
            'quantity' => [
                'add'       => Sum::class,
                'remove'    => Subtract::class,
            ],
            'value'     => [
                'add'       => AddQuantityMultiple::class,
                'remove'    => SubtractQuantityMultiple::class,
            ],
        ];
    }

    protected array $containerItemRelations = [
        'container' => 'containerNotSummarized',
        'item'      => 'itemNotSummarized',
    ];

    public function containerNotSummarized() : BelongsTo
    {
        return $this->belongsTo(ContainerNotSummarized::class);
    }

    public function itemNotSummarized() : BelongsTo
    {
        return $this->belongsTo(ItemNotSummarized::class);
    }
}
