<?php

namespace Psrearick\Containers\Concerns;

trait IsSummarized
{
    public bool $isSummarized = true;

    public function foreignIds() : array
    {
        return [
            'container' => 'container_id',
            'item'      => 'item_id',
        ];
    }
}
