<?php

namespace Psrearick\Containers\Traits;

trait ItemBaseAttributes
{
    protected array $aggregateAttributes = ['quantity', 'change', 'containers'];

    public function aggregateAttributes() : array
    {
        return $this->aggregateAttributes;
    }
}
