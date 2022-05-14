<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Psrearick\Containers\Concerns\IsSummarizable;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Models\Item as Base;
use Psrearick\Containers\Tests\Factories\ItemFactory;

/**
 * @property float $quantity
 * @property float $value
 * @property Collection containerItemSummaries
 */
class Item extends Base implements SummarizableItem
{
    use HasFactory;
    use IsSummarizable;

    protected array $computeAttributes = ['quantity', 'value'];

    protected array $containerItemRelations = [
        Container::class => 'containerItems',
    ];

    protected array $containerItemSummaryRelations = [
        ContainerItem::class => 'containerItemSummaries',
    ];

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerItem::class);
    }

    public function containerItemSummaries() : HasMany
    {
        return $this->hasMany(ContainerItemSummary::class);
    }

    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }
}
