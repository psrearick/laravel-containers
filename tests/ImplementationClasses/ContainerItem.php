<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected array $computeAttributes = ['quantity', 'value'];

    protected bool $isSummarized = true;

    protected string $summarizedBy = 'containerItemSummary';

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
}
