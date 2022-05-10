<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Domain\Containers\Aggregate\ContainersAggregateRoot;
use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerWasCreated;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Domain\Summaries\Models\ContainerSummary;

/**
 * @property int $id
 * @property int $parentId
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|null $containerItems
 */
trait Containerable
{
    use Aggregatable;
    use DefinesClass;
    use HasUuid;

    protected array $events = [
        'created' => [
            ContainerWasCreated::class,
        ],
    ];

    protected string $modelName = 'container';

    protected function classes(string $key) : string
    {
        $classList = [
            'aggregateRoot'     => ContainersAggregateRoot::class,
            'containerItem'     => ContainerItem::class,
            'containerSummary'  => ContainerSummary::class,
        ];

        return $classList[$key] ?? '';
    }

    public function containerItems() : MorphMany
    {
        return $this->morphMany($this->classes('containerItem'), 'containerable', null, 'containerable_uuid', 'uuid');
    }

    public function containerSummary() : MorphOne
    {
        return $this->morphOne($this->classes('containerSummary'), 'containerable', null, 'containerable_uuid', 'uuid');
    }
}
