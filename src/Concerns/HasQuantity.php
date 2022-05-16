<?php

namespace Psrearick\Containers\Concerns;

use Psrearick\Containers\Exceptions\PropertyNotDefinedException;

trait HasQuantity
{
    public function quantityFieldName() : string
    {
        if (! property_exists(__CLASS__, 'quantityFieldName')) {
            throw new PropertyNotDefinedException('The quantityFieldName property does not exist on this instance');
        }

        return $this->quantityFieldName;
    }
}
