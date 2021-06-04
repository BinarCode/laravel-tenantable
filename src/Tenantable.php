<?php

namespace BinarCode\Tenantable;

class Tenantable
{
    public static function useColumn(string $column): void
    {
        config()->set('tenantable.related_tenant_column', $column);
    }
}
