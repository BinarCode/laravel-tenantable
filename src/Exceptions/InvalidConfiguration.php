<?php

namespace BinarCode\Tenantable\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function tenantConnectionDoesNotExist(string $expectedConnectionName): self
    {
        return new static("Could not find a tenant connection named `{$expectedConnectionName}`. Make sure to create a connection with that name in the `connections` key of the `database` config file.");
    }
}
