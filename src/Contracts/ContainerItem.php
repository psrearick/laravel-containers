<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface ContainerItem extends Model
{
    public function containerable() : MorphTo;

    public function itemable() : MorphTo;
}
