<?php

namespace Psrearick\Containers\Contracts;

/**
 * @property array $attributes
 */
interface Eventable extends Model
{
    public function aggregateAttributes() : array;

    public function root() : ?AggregateRoot;
}
