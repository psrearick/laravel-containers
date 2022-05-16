<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerOuter extends Base
{
    protected array $computeAttributes = ['quantity', 'value'];

    public function container() : BelongsTo
    {
        return $this->belongsTo(Outer::class, 'outer_id');
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'container_id');
    }
}
