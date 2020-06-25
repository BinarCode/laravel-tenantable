<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;

class AuthGuardPipe implements Pipelineable
{
    public function __invoke(Tenant $tenant, callable $next)
    {
        config([
            'auth.guards.web.provider' => 'tenants',
        ]);

        return $next($tenant);
    }
}
