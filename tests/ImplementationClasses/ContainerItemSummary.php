<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Contracts\Summary;

class ContainerItemSummary extends Model implements Summary
{
    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
