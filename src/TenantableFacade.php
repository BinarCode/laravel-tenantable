<?php

namespace BinarCode\Tenantable;

use Illuminate\Support\Facades\Facade;

/**
 * @method static useColumn(string $column)
 * @see Tenantable
 */
class TenantableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tenantable';
    }
}
