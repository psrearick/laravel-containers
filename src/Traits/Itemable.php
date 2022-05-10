<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|null $containerItems
 */
trait Itemable
{
    use Aggregatable;
    use DefinesClass;
    use HasUuid;

    protected array $events = [
        'created' => [
            ItemWasCreated::class,
        ],
    ];

    protected function classes(string $key) : string
    {
        $classList = [
            'aggregateRoot' => ItemsAggregateRoot::class,
            'containerItem' => ContainerItem::class,
        ];

        return $classList[$key] ?? '';
    }

    protected string $modelName = 'item';

    public function containerItems() : MorphMany
    {
        return $this->morphMany($this->classes('containerItem'), 'itemable', null, 'itemable_uuid', 'uuid');
    }

    public function containers() : Collection
    {
        return $this
            ->containerItems()
            ->with('containerable')
            ->get()
            ->map(fn (ContainerItemContract $containerItem) => $containerItem->containerable);
    }
}
