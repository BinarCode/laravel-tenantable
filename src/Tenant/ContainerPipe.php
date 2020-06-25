<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;

class ContainerPipe implements Pipelineable
{
    public function __invoke(Tenantable $tenant, callable $next)
    {
        app()->forgetInstance($tenant->containerKey());

        app()->forgetInstance(Tenantable::class);

        app()->instance($tenant->containerKey(), $tenant);

        app()->instance(Tenantable::class, $tenant);

        return $next($tenant);
    }
}
