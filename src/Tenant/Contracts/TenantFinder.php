<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface TenantFinder
{
    public function __invoke(): ?Tenant;
}
