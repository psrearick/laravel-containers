<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerContainer extends Base
{
    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'parent_id');
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'child_id');
    }
}
