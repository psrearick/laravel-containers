<?php

namespace Psrearick\Containers\Contracts;

use ArrayAccess;
use Carbon\Carbon;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method \Illuminate\Database\Eloquent\Model refresh()
 * @method \Illuminate\Database\Eloquent\Model update(array $update)
 * @method bool is(?\Illuminate\Database\Eloquent\Model $model)
 */
interface Model extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString, HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
}
