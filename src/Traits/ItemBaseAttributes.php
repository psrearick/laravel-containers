<?php

namespace Psrearick\Containers\Traits;

trait ItemBaseAttributes
{
    protected array $aggregateAttributes = ['quantity', 'containers'];

    public function aggregateAttributes() : array
    {
        return $this->aggregateAttributes;
    }
}
