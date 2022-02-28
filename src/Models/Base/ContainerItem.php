<?php

namespace Psrearick\Containers\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;
use Psrearick\Containers\Models\Container;
use Psrearick\Containers\Models\Item;
use Psrearick\Containers\Models\Traits\HasUuid;

/**
 * Psrearick\Containers\Models\Base\ContainerItem
 *
 * @property int $id
 * @property string $uuid
 * @property string $container_uuid
 * @property string $container_model
 * @property string $item_uuid
 * @property string $item_model
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Container|null $container
 * @property-read Item|null $item
 */
abstract class ContainerItem extends Model implements ContainerItemContract
{
    use SoftDeletes;
    use HasFactory;
    use HasUuid;

    protected string $containerClass = Container::class;

    protected string $itemClass = Item::class;

    public static function boot() : void
    {
        parent::boot();

        static::saving(static function (ContainerItem $model) {
            $model->container_model = $model->containerClass;
            $model->item_model      = $model->containerClass;
        });
    }

    public function container() : BelongsTo
    {
        return $this->belongsTo($this->containerClass, 'container_uuid', 'uuid');
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo($this->itemClass, 'item_uuid', 'uuid');
    }
}
