<?php

namespace BinarCode\Tenantable\Models\Concerns;

trait UsesTenantConnection
{
    use UsesTenantConfig;

    public function getConnectionName()
    {
        return $this->tenantDatabaseConnectionName();
    }
}
