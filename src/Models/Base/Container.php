<?php

namespace Psrearick\Containers\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Models\Traits\DefinesClass;
use Psrearick\Containers\Models\Traits\HasUuid;

abstract class Container extends Model implements ContainerContract
{
    use DefinesClass;
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
