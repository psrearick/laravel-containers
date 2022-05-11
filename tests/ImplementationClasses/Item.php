<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Tests\Factories\ItemFactory;

class Item extends Model implements ItemContract
{
    use HasFactory;
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
        return [Container::class => 'containers'];
    }

    public function containerItemSummary() : HasMany
    {
        return $this->hasMany(ContainerItemSummary::class);
    }

    public function containers() : BelongsToMany
    {
        return $this->belongsToMany(Container::class)
            ->using(ContainerItem::class)
            ->withPivot('quantity', 'value', 'id')
            ->withTimestamps();
    }

    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }
}
