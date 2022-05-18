<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Computations\AddQuantityMultiple;
use Psrearick\Containers\Computations\Subtract;
use Psrearick\Containers\Computations\SubtractQuantityMultiple;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Models\Summary as Base;

/**
 * @property float $value
 * @property float $quantity
 */
class ContainerContainerSummary extends Base
{
    public function computations() : array
    {
        return [
            Container::class => [
                'quantity' => [
                    'add'       => Sum::class,
                    'remove'    => Subtract::class,
                ],
                'value'     => [
                    'add'       => AddQuantityMultiple::class,
                    'remove'    => SubtractQuantityMultiple::class,
                ],
            ],
        ];
    }

    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'parent_id');
    }

    public function containerItems() : HasMany
    {
        return $this->hasMany(ContainerContainer::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'child_id');
    }
}
