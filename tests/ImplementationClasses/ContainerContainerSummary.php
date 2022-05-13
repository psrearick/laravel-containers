<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Contracts\Summary;

class ContainerContainerSummary extends Model implements Summary
{
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
