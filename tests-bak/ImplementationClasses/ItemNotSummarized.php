<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Models\Item as Base;
use Psrearick\Containers\Tests\Factories\ItemNotSummarizedFactory;

/**
 * @property float $quantity
 * @property float $value
 */
class ItemNotSummarized extends Base
{
    use HasFactory;

    protected array $containerItemRelations = [
        ContainerNotSummarized::class => 'containerItemsNotSummarized',
    ];

    public function containerItemsNotSummarized() : HasMany
    {
        return $this->hasMany(ContainerItemNotSummarized::class);
    }

    protected static function newFactory() : ItemNotSummarizedFactory
    {
        return ItemNotSummarizedFactory::new();
    }
}
