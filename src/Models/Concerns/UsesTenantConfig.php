<?php

namespace BinarCode\Tenantable\Models\Concerns;

trait UsesTenantConfig
{
    public function tenantDatabaseConnectionName(): ?string
    {
        return config('tenantable.tenant_database_connection_name') ?? config('database.default');
    }

    public function masterDatabaseConnectionName(): ?string
    {
        return config('tenantable.master_database_connection_name', 'master');
    }

    public function containerKey(): string
    {
        return config('tenantable.container_key');
    }
}
