<?php

namespace Psrearick\Containers\Concerns;

use Psrearick\Containers\Exceptions\PropertyNotDefinedException;

trait IsContainerItemable
{
    public function containerItemRelations() : array
    {
        if (! property_exists(__CLASS__, 'containerItemRelations')) {
            throw new PropertyNotDefinedException('The containerItemRelations property does not exist on this instance');
        }

        return $this->containerItemRelations;
    }

    public function isSingleton() : bool
    {
        if (! property_exists(__CLASS__, 'isSingleton')) {
            throw new PropertyNotDefinedException('The isSingleton property does not exist on this instance');
        }

        return $this->isSingleton;
    }

    public function isSummarized() : bool
    {
        if (! property_exists(__CLASS__, 'isSummarized')) {
            throw new PropertyNotDefinedException('The isSummarized property does not exist on this instance');
        }

        return $this->isSummarized;
    }

    public function summarizedBy() : string
    {
        if (! property_exists(__CLASS__, 'summarizedBy')) {
            throw new PropertyNotDefinedException('The summarizedBy property does not exist on this instance');
        }

        return $this->summarizedBy;
    }
}
