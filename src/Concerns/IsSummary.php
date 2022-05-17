<?php

namespace Psrearick\Containers\Concerns;

trait IsSummary
{
    public function containerItemSummaryRelations() : array
    {
        if (! property_exists(__CLASS__, 'containerItemSummaryRelations')) {
            return [];
        }

        return $this->containerItemSummaryRelations;
    }
}
