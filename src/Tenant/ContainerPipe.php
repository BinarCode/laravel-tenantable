<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;

class ContainerPipe implements Pipelineable
{
    public function __invoke(Tenant $tenant, callable $next)
    {
        app()->forgetInstance($tenant->containerKey());

        app()->forgetInstance(Tenant::class);

        app()->instance($tenant->containerKey(), $tenant);

        app()->instance(Tenant::class, $tenant);

        return $next($tenant);
    }
}
