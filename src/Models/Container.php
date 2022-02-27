<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Models\Traits\DefinesClass;
use Psrearick\Containers\Models\Traits\HasUuid;

class Container extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUuid;
    use DefinesClass;

    protected $guarded = [];

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
