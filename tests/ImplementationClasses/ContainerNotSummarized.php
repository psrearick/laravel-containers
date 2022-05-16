<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Models\Container as Base;
use Psrearick\Containers\Tests\Factories\ContainerNotSummarizedFactory;

class ContainerNotSummarized extends Base implements ItemContract
{
    use HasComputations;
    use HasFactory;
    use IsItemable;

    protected array $computeAttributes = ['quantity', 'value'];

    protected array $containerItemRelations = [
        ItemNotSummarized::class => 'containerItemsNotSummarized',
    ];

    public function containerItemsNotSummarized() : HasMany
    {
        return $this->hasMany(ContainerItemNotSummarized::class);
    }

    protected static function newFactory() : ContainerNotSummarizedFactory
    {
        return ContainerNotSummarizedFactory::new();
    }
}
