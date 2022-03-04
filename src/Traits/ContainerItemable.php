<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait ContainerItemable
{
    public function containerable() : MorphTo
    {
        return $this->morphTo('containerable', null, 'containerable_uuid', 'uuid');
    }

    public function itemable() : MorphTo
    {
        return $this->morphTo('itemable', null, 'itemable_uuid', 'uuid');
    }
}
