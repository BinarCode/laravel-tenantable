<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface Pipelineable
{
    public function __invoke(Tenantable $tenant, callable $next);
}
