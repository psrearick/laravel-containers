<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Concerns\IsSummarizable;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Models\Container as Base;
use Psrearick\Containers\Tests\Factories\ContainerFactory;

/**
 * @property float $quantity
 * @property float $value
 */
class Container extends Base implements SummarizableItem, SummarizableContainer
{
    use HasComputations;
    use HasFactory;
    use IsItemable;
    use IsSummarizable;

    protected $casts = [
        'quantity'  => 'float',
        'value'     => 'float',
    ];

    protected array $computeAttributes = ['quantity', 'value'];

    protected array $containerItemRelations = [
        'item'      => [
            Outer::class    => 'containerOuters',
            __CLASS__       => 'containerContainersChild',
        ],
        'container' => [
            Item::class     => 'containerItems',
            __CLASS__       => 'containerContainersParent',
        ],
    ];

    protected array $containerItemSummaryRelations = [
        'item'      => [
            ContainerItem::class        => 'containerItemSummaries',
            ContainerContainer::class   => 'childContainerContainerSummaries',
        ],
        'container' => [
            ContainerContainer::class   => 'parentContainerContainerSummaries',
        ],
    ];

    public function containerContainersChild() : HasMany
    {
        return $this->hasMany(ContainerContainer::class, 'child_id');
    }

    public function containerContainersParent() : HasMany
    {
        return $this->hasMany(ContainerContainer::class, 'parent_id');
    }

    public function parentContainerContainerSummaries() : HasMany
    {
        return $this->hasMany(ContainerContainerSummary::class, 'parent_id');
    }

    public function childContainerContainerSummaries() : HasMany
    {
        return $this->hasMany(ContainerContainerSummary::class, 'child_id');
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerItem::class);
    }

    public function containerItemSummaries() : HasMany
    {
        return $this->hasMany(ContainerItemSummary::class);
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
