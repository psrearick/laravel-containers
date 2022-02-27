<?php

namespace Psrearick\Containers\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Models\Traits\DefinesClass;
use Psrearick\Containers\Models\Traits\HasUuid;

abstract class Item extends Model implements ItemContract
{
    use DefinesClass;
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected $dispatchesEvents = [
        'created' => ItemWasCreated::class,
    ];

    protected $guarded = [];
}
