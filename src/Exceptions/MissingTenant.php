<?php

namespace BinarCode\Tenantable\Exceptions;

use Exception;

class MissingTenant extends Exception
{
    public static function make()
    {
        return new static('The request expected a current tenant but none was set.');
    }
}
