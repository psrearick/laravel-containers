<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContainerItemSummary extends Model
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
