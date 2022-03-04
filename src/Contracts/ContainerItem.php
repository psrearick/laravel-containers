<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface ContainerItem extends Model
{
    public function container() : BelongsTo;

    public function item() : BelongsTo;
}
