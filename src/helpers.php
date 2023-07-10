<?php

use BinarCode\Tenantable\Tenant\Contracts\Tenantable;

function tenant(): Tenantable
{
    return app(Tenantable::class);
}

function fromTenant($property = null)
{
    return data_get(app(Tenantable::class), $property);
}

if (! function_exists('withoutProtocol')) {
    function withoutProtocol(string $fqdn = ''): string
    {
        return str_replace(['https://', 'http://', 'www.'], ['https://' => '', 'http://' => '', 'www.' => ''], $fqdn);
    }
}
