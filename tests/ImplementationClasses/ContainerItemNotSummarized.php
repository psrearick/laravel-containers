<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected array $computeAttributes = ['quantity', 'value'];

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
