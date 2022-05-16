<?php

namespace Psrearick\Containers\Exceptions;

use Exception;

class PropertyNotDefinedException extends Exception
{
    public function __construct(string $message = 'property does not exist on this instance')
    {
        parent::__construct($message);
    }
}
