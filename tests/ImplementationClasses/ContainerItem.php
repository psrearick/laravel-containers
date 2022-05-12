<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsSummarized;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Models\ContainerItem as Base;

/**
 * @property float $quantity
 * @property float $value
 */
class ContainerItem extends Base implements Summarized
{
    protected $casts = [
        'quantity'  => 'float',
        'value'     => 'float',
    ];

    protected bool $isSummarized = true;

    public function computations() : array
    {
        return [
            'quantity'  => Sum::class,
            'value'     => Sum::class,
        ];
    }

    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function containerItemSummary() : BelongsTo
    {
        return $this->belongsTo(ContainerItemSummary::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function summarizedBy() : string
    {
        return 'containerItemSummary';
    }
}
