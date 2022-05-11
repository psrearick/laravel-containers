<?php

namespace Psrearick\Containers\Contracts;

interface Container extends Model
{
    public function contains() : array;

    public function containsRelationName(Item $item) : string;
}
