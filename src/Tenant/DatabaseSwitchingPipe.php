<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Exceptions\InvalidConfiguration;
use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Support\Facades\DB;

class DatabaseSwitchingPipe implements Pipelineable
{
    public function __invoke(Tenantable $tenant, callable $next)
    {
        $tenantConnectionName = $tenant->tenantDatabaseConnectionName();

        if (is_null(config("database.connections.{$tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }

        config([
            'database.connections.tenant.database' => $tenant->databaseConfig()->name(),
        ]);


        DB::purge($tenantConnectionName);

        DB::reconnect($tenantConnectionName);

        return $next($tenant);
    }
}
