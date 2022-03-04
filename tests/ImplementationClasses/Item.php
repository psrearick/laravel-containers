<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Database\Factories\ItemFactory;
use Psrearick\Containers\Domain\Summaries\Aggregate\Actions\CountContainerItems;
use Psrearick\Containers\Traits\Itemable;

class Item extends Model implements ItemContract
{
    use HasFactory;
    use Itemable;

    public function actions() : array
    {
        return [
            'created' => [
                CountContainerItems::class,
            ],
        ];
    }

    public function aggregateAttributes() : array
    {
        return ['quantity', 'containers'];
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
