<?php

namespace Psrearick\Containers\Contracts;

interface Summary extends Model
{
    /** provide an array of computation classes available to this summary */
    public function computations() : array;

    /** The relationship method names associated with the summary. Key should be container, item, containerItems. */
    public function containerItemSummaryRelations() : array;

    /** The name of the field use to define the summary quantity */
    public function quantityFieldName() : string;
}
