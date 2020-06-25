<?php

namespace BinarCode\Tenantable\Exceptions;

use Exception;

class BecauseDatabase extends Exception
{
    public static function exists(string $name)
    {
        return new static("Database $name already exists. Please use another name by defining the [key] method in BecauseDatabaseBecauseDatabaseBecauseDatabaseyour Tenant.");
    }
}
