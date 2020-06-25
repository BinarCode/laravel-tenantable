<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;

class CachePipe implements Pipelineable
{
    public function __invoke(Tenant $tenant, callable $next)
    {
        cache()->set('prefix', $tenant->key());

        cache()->forgetDriver(
            config('cache.default')
        );

        return $next($tenant);
    }
}
