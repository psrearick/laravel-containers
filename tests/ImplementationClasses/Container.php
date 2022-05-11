<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function containedBy() : array
    {
        return [Outer::class => 'outers'];
    }

    public function contains() : array
    {
        return [Item::class => 'items'];
    }

    public function items() : BelongsToMany
    {
        return $this->belongsToMany(Item::class)
        ->using(ContainerItem::class)
        ->withPivot('quantity', 'value', 'id')
        ->withTimestamps();
    }

    public function outers() : BelongsToMany
    {
        return $this->belongsToMany(Outer::class)->using(ContainerOuter::class);
    }

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
