<?php

namespace Psrearick\Containers\Domain\Base;

use Eloquent as EloquentBase;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @mixin EloquentBase
 */
class Model extends Eloquent
{
    protected $guarded = [];
}
