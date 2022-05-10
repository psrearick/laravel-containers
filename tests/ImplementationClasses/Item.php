<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Database\Factories\ItemFactory;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot;
use Psrearick\Containers\Traits\Itemable;
use Psrearick\Containers\Traits\ItemBaseActions;
use Psrearick\Containers\Traits\ItemBaseAttributes;

/**
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $deleted_at
 */
class Item extends Model implements ItemContract
{
    use HasFactory;
    use Itemable;
    use ItemBaseActions;
    use ItemBaseAttributes;

    protected function classes(string $key) : string
    {
        $classList = [
            'aggregateRoot' => ItemsAggregateRoot::class,
            'containerItem' => ContainerItem::class,
        ];

        return $classList[$key] ?? '';
    }

    public function containerModels() : array
    {
        return [Container::class];
    }

    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }
}
