<?php

function tenant(): Tenant
{
    return app(BinarCode\Tenantable\Tenant\Contracts\Tenant::class);
}

function fromTenant($property = null)
{
    return data_get(app(BinarCode\Tenantable\Tenant\Contracts\Tenant::class), $property);
}

