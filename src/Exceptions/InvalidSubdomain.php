<?php

namespace BinarCode\Tenantable\Exceptions;

use Exception;

class InvalidSubdomain extends Exception
{
    public static function make($actual)
    {
        return new static("Provided invalid domain [{$actual}].");
    }
}
