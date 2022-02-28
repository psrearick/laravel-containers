<?php

namespace Psrearick\Containers\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Events\ItemWasDeleted;
use Psrearick\Containers\Events\ItemWasUpdated;
use Psrearick\Containers\Models\ContainerItem;
use Psrearick\Containers\Models\Traits\DefinesClass;
use Psrearick\Containers\Models\Traits\HasUuid;

/**
 * Psrearick\Containers\Models\Base\Item
 *
 * @property int $id
 * @property string $uuid
 * @property string $model
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ContainerItem|null $containerItem
 */
abstract class Item extends Model implements ItemContract
{
    use DefinesClass;
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected $dispatchesEvents = [
        'created'   => ItemWasCreated::class,
        'deleted'   => ItemWasDeleted::class,
        'updated'   => ItemWasUpdated::class,
    ];

    protected string $containerItemClass = ContainerItem::class;

    public function containerItem() : BelongsTo
    {
        return $this->belongsTo($this->containerItemClass, 'uuid', 'item_uuid');
    }
}
