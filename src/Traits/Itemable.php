<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|null $containerItems
 */
trait Itemable
{
    use DefinesClass;
    use HasUuid;
    use Aggregatable;

    protected string $aggregateRootClass = ItemsAggregateRoot::class;

    protected array $events = [
        'created' => [
            ItemWasCreated::class,
        ],
    ];

    protected string $modelName = 'item';

//    protected ?ItemsAggregateRoot $root = null;

    public function containerItems() : MorphMany
    {
        return $this->morphMany(ContainerItem::class, 'itemable', null, 'itemable_uuid', 'uuid');
    }

    public function containers() : Collection
    {
        return $this
            ->containerItems()
            ->with('containerable')
            ->get()
            ->map(fn (ContainerItem $containerItem) => $containerItem->containerable);
    }

//    public function root() : ?ItemsAggregateRoot
//    {
//        return $this->root;
//    }

//    protected static function bootItemable() : void
//    {
//        static::created(static function (Item $item) {
//            ItemWasCreated::dispatch($item);
//        });
//
//        static::creating(static function (Item $item) {
//            foreach ($item->aggregateAttributes() as $attribute) {
//                if (! array_key_exists($attribute, $item->attributes)) {
//                    continue;
//                }
//
//                $item->root()->$attribute = $item->$attribute;
//
//                unset($item->$attribute);
//            }
//        });
//    }
//
//    protected function initializeItemable() : void
//    {
//        $this->setRoot();
//    }
//
//    protected function setRoot() : void
//    {
//        $this->root       = new ItemsAggregateRoot();
//        $this->root->item = $this;
//    }
}
