<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Concerns\IsContainerable;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Tests\Factories\ContainerFactory;

class Container extends Model implements SummarizableItem, SummarizableContainer
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

    public function containerContainersChild() : HasMany
    {
        return $this->hasMany(ContainerContainer::class, 'child_id');
    }

    public function containerContainersParent() : HasMany
    {
        return $this->hasMany(ContainerContainer::class, 'parent_id');
    }

    public function containerItemRelations() : array
    {
        return [
            'item'      => [
                Outer::class    => 'containerOuters',
                __CLASS__       => 'containerContainersChild',
            ],
            'container' => [
                Item::class     => 'containerItems',
                __CLASS__       => 'containerContainersParent',
            ],
        ];
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerItem::class);
    }

    public function containerItemSummaries() : HasMany
    {
        return $this->hasMany(ContainerItemSummary::class);
    }

    public function containerItemSummaryRelations() : array
    {
        return [ContainerItem::class => 'containerItemSummaries'];
    }

    public function containerOuters() : HasMany
    {
        return $this->hasMany(ContainerOuter::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
