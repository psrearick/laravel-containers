<?php

namespace Psrearick\Containers\Domain\Containers\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Domain\Base\Model;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Traits\DefinesClass;
use Psrearick\Containers\Traits\HasUuid;

/**
 * Psrearick\Containers\Domain\Containers\Models\Base\Container
 *
 * @property int $id
 * @property string $uuid
 * @property string $model
 * @property string $name
 * @property string|null $description
 * @property int $_lft
 * @property int $_rgt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ContainerItem|null $containerItem
 */
abstract class Container extends Model implements ContainerContract
{
    use DefinesClass;
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected string $containerItemClass = ContainerItem::class;

    public function containerItem() : BelongsTo
    {
        return $this->belongsTo($this->containerItemClass, 'uuid', 'container_uuid');
    }
}
