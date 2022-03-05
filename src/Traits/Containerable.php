<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Domain\Containers\Aggregate\ContainersAggregateRoot;
use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerWasCreated;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;

/**
 * @property int $id
 * @property int $_lft
 * @property int $_rgt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|null $containerItems
 */
trait Containerable
{
    use Aggregatable;
    use DefinesClass;
    use HasUuid;

    protected string $aggregateRootClass = ContainersAggregateRoot::class;

    protected array $events = [
        'created' => [
            ContainerWasCreated::class,
        ],
    ];

    protected string $modelName = 'container';

    public function containerItems() : MorphMany
    {
        return $this->morphMany(ContainerItem::class, 'containerable', null, 'containerable_uuid', 'uuid');
    }
}
