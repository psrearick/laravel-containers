<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;

trait Containerable
{
    use HasUuid;

    public function containerItems() : MorphMany
    {
        return $this->morphMany(ContainerItem::class, 'containerable', null, 'containerable_uuid', 'uuid');
    }
}
