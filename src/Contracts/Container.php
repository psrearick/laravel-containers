<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $model
 * @property string $uuid
 * @property int $_lft
 * @property int $_rgt
 * @property-read Collection|null $containerItems
 */
interface Container extends Eventable
{
    public function containerItems() : MorphMany;
}
