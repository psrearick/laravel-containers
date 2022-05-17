<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Models\Summary as Base;
use Psrearick\Containers\Tests\ImplementationClasses\Traits\ItemComputation;

/**
 * @property float $value
 * @property float $quantity
 */
class ContainerContainerSummary extends Base
{
    use ItemComputation;

    public function computations() : array
    {
        return $this->itemComputations;
    }

    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'parent_id');
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerContainer::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'child_id');
    }
}
