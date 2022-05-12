<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Item as Contract;
use Psrearick\Containers\Tests\Factories\ItemNotSummarizedFactory;

class ItemNotSummarized extends Model implements Contract
{
    use IsItemable;
    use HasFactory;

    public function computations() : array
    {
        return [
            'quantity'  => Sum::class,
            'value'     => Sum::class,
        ];
    }

    public function containerItemRelations() : array
    {
        return [ContainerNotSummarized::class => 'containerItemsNotSummarized'];
    }

    public function containerItemsNotSummarized() : HasMany
    {
        return $this->hasMany(ContainerItemNotSummarized::class);
    }

    protected static function newFactory() : ItemNotSummarizedFactory
    {
        return ItemNotSummarizedFactory::new();
    }
}
