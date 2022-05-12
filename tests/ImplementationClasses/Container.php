<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsContainerable;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Tests\Factories\ContainerFactory;

class Container extends Model implements ContainerContract, ItemContract
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

//    public function containedBy() : array
//    {
//        return [Outer::class => 'outers'];
//    }
//
//    public function contains() : array
//    {
//        return [Item::class => 'items'];
//    }

    public function containerItemRelations() : array
    {
        return [
            Item::class  => 'containerItems',
            Outer::class => 'containerOuters',
        ];
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerItem::class);
    }

    public function containerOuters() : HasMany
    {
        return $this->hasMany(ContainerOuter::class);
    }

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
