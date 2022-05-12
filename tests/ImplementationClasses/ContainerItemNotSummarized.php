<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerItemNotSummarized extends Base
{
    protected $casts = [
        'quantity'  => 'float',
        'value'     => 'float',
    ];

    public function containerItemRelations() : array
    {
        return [
            'container' => 'containerNotSummarized',
            'item'      => 'itemNotSummarized',
        ];
    }

    public function containerNotSummarized() : BelongsTo
    {
        return $this->belongsTo(ContainerNotSummarized::class);
    }

    public function itemNotSummarized() : BelongsTo
    {
        return $this->belongsTo(ItemNotSummarized::class);
    }
}
