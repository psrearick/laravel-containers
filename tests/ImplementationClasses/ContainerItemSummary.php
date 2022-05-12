<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Contracts\Summary;

class ContainerItemSummary extends Model implements Summary
{
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
