<?php

namespace BinarCode\Tenantable;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BinarCode\LaravelThirdParty\Tenantable
 */
class TenantableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tenantable';
    }
}
