<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerContainer extends Base implements Summarized
{
    protected array $computeAttributes = ['quantity', 'value'];

    protected bool $isSummarized = true;

    protected bool $isSingleton = true;

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
