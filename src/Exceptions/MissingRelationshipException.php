<?php

namespace Psrearick\Containers\Exceptions;

use Exception;

class MissingRelationshipException extends Exception
{
    public function __construct(string $message = 'The class provided does not have an associated relationship')
    {
        parent::__construct($message);
    }
}
