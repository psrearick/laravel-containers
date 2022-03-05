<?php

namespace Psrearick\Containers\Traits;

trait ContainerBaseAttributes
{
    protected array $aggregateAttributes = [];

    public function aggregateAttributes() : array
    {
        return $this->aggregateAttributes;
    }
}
