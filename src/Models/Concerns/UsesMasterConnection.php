<?php

namespace BinarCode\Tenantable\Models\Concerns;

trait UsesMasterConnection
{
    use UsesTenantConfig;

    public function getConnectionName()
    {
        return $this->masterDatabaseConnectionName();
    }
}
