<?php

namespace Psrearick\Containers\Concerns;

trait HasComputations
{
    public function computations() : array
    {
        if (! property_exists(__CLASS__, 'computeAttributes')) {
            return [];
        }

        $computations = [];

        foreach ($this->computeAttributes as $attribute) {
            $computations[$attribute] = [
                'add'       => config('containers.default_add_computation'),
                'remove'    => config('containers.default_remove_computation'),
            ];
        }

        return $computations;
    }
}
