<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface Pipelineable
{
    public function __invoke(Tenant $tenant, callable $next);
}
