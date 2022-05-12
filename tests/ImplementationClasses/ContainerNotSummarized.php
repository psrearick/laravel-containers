<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsContainerable;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Tests\Factories\ContainerNotSummarizedFactory;

class ContainerNotSummarized extends Model implements ContainerContract, ItemContract
{
    use HasFactory;
    use IsContainerable;
    use IsItemable;

    public function computations() : array
    {
        return [
            'quantity'  => Sum::class,
            'value'     => Sum::class,
        ];
    }

    public function containerItemRelations() : array
    {
        return [ItemNotSummarized::class => 'containerItemsNotSummarized'];
    }

    public function containerItemsNotSummarized() : HasMany
    {
        return $this->hasMany(ContainerItemNotSummarized::class);
    }

    protected static function newFactory() : ContainerNotSummarizedFactory
    {
        return ContainerNotSummarizedFactory::new();
    }
}
