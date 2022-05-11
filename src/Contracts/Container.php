<?php

namespace Psrearick\Containers\Contracts;

interface Container extends Model
{
    public function contains() : array;
}
