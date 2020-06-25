<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;

class CachePipe implements Pipelineable
{
    public function __invoke(Tenantable $tenant, callable $next)
    {
        cache()->set('prefix', $tenant->key());

        cache()->forgetDriver(
            config('cache.default')
        );

        return $next($tenant);
    }
}
