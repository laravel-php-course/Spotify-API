<?php

namespace App\Exceptions;

use Exception;

class InvalidRoleException extends Exception
{
    public function __construct($message = "Invalid role provided", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
