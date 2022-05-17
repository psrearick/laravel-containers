<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Computations\AddQuantityMultiple;
use Psrearick\Containers\Computations\Subtract;
use Psrearick\Containers\Computations\SubtractQuantityMultiple;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerContainer extends Base implements Summarized
{
    public function computations(): array
    {
        return [
            'quantity' => [
                'add'       => Sum::class,
                'remove'    => Subtract::class,
            ],
            'value'     => [
                'add'       => AddQuantityMultiple::class,
                'remove'    => SubtractQuantityMultiple::class,
            ],
        ];
    }

    protected bool $isSingleton = true;

    protected bool $isSummarized = true;

    protected string $summarizedBy = 'containerContainerSummary';

    public function container() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'parent_id');
    }

    public function containerContainerSummary() : BelongsTo
    {
        return $this->belongsTo(ContainerContainerSummary::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'child_id');
    }
}
