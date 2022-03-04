<?php

namespace Psrearick\Containers\Domain\Items\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Domain\Base\Model;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasDeleted;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasUpdated;
use Psrearick\Containers\Traits\DefinesClass;
use Psrearick\Containers\Traits\HasUuid;

/**
 * Psrearick\Containers\Domain\Items\Models\Base\Item
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

    protected string $containerItemClass = ContainerItem::class;

    protected $dispatchesEvents = [
        'created'   => ItemWasCreated::class,
        'deleted'   => ItemWasDeleted::class,
        'updated'   => ItemWasUpdated::class,
    ];

    public function containerItem() : BelongsTo
    {
        return $this->belongsTo($this->containerItemClass, 'uuid', 'item_uuid');
    }
}
