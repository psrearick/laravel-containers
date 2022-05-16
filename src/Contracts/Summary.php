<?php

namespace Psrearick\Containers\Contracts;

interface Summary extends Model
{
    /** provide an array of computation classes available to this summary */
    public function computations() : array;

    /** The name of the field use to define the summary quantity */
    public function quantityFieldName() : string;
}
