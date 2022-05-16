<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Models\Summary as Base;

/**
 * @property float $value
 * @property float $quantity
 */
class ContainerItemSummary extends Base
{
    protected array $computeAttributes = ['quantity', 'value'];

    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerItem::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
