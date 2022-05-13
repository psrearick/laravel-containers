<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerContainer extends Base implements Summarized
{
    protected bool $isSummarized = true;

    public function computations() : array
    {
        return [
            'quantity'  => Sum::class,
            'value'     => Sum::class,
        ];
    }

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

    public function summarizedBy() : string
    {
        return 'containerContainerSummary';
    }
}
