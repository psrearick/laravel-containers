<?php

namespace Psrearick\Containers\Domain\Summaries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Psrearick\Containers\Contracts\ContainerSummary as ContainerSummaryContract;

class ContainerSummary extends Model implements ContainerSummaryContract
{
    public function containerable() : MorphTo
    {
        return $this->morphTo('containerable', null, 'containerable_uuid', 'uuid');
    }
}
