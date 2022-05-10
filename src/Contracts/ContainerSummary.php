<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface ContainerSummary extends Model
{
    public function containerable() : MorphTo;
}
