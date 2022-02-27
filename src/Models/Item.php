<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Models\Traits\DefinesClass;
use Psrearick\Containers\Models\Traits\HasUuid;

class Item extends Model implements ItemContract
{
    use SoftDeletes;
    use HasFactory;
    use HasUuid;
    use DefinesClass;

    protected $dispatchesEvents = [
        'created' => ItemWasCreated::class,
    ];

    protected $guarded = [];
}
