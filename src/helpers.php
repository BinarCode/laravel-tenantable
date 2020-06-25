<?php

use BinarCode\Tenantable\Tenant\Contracts\Tenant;

function tenant(): Tenant
{
    return app(Tenant::class);
}

function fromTenant($property = null)
{
    return data_get(app(Tenant::class), $property);
}
