<?php

namespace Psrearick\Containers\Exceptions;

use Exception;
use Throwable;

class ContainerItemNotFoundException extends Exception
{
    public function __construct(string $message = 'Container item was not found', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
