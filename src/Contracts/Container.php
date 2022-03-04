<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Container extends Model
{
    public function containerItems() : MorphMany;
}
