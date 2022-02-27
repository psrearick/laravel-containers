<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;

abstract class Item extends Model implements ItemContract
{
    protected $dispatchesEvents = [
        'created' => ItemWasCreated::class,
    ];
}
