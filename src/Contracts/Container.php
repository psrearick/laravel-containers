<?php

namespace Psrearick\Containers\Contracts;

/**
 * @method Container refresh()
 */
interface Container extends Model
{
    public function contains() : array;

    public function containsRelationName(Item $item) : string;
}
