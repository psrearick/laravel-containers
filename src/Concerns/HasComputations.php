<?php

namespace Psrearick\Containers\Concerns;

use Psrearick\Containers\Exceptions\PropertyNotDefinedException;

trait HasComputations
{
    public function computations() : array
    {
        if (! property_exists(__CLASS__, 'computeAttributes')) {
            throw new PropertyNotDefinedException('The computeAttributes property does not exist on this instance');
        }

        $computations = [];

        foreach ($this->computeAttributes as $class => $computeAttribute) {
            $classComputations = [];
            foreach ($computeAttribute as $attribute) {
                $classComputations[$attribute] = [
                    'add'       => config('containers.default_add_computation'),
                    'remove'    => config('containers.default_remove_computation'),
                ];
            }
            $computations[$class] = $classComputations;
        }

        return $computations;
    }
}
