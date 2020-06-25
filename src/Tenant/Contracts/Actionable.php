<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface Actionable
{
    public function __invoke(Tenant $tenant);
}
