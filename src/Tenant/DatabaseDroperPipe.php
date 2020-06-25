<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Config\Repository;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

class DatabaseDroperPipe implements Pipelineable
{
    /** * @var string */
    private $connection;

    /**
     * @var Repository
     */
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->connection = $config->get('tenant.master_database_connection_name');
    }

    public function __invoke(Tenant $tenant, callable $next)
    {
        if (! $this->databaseExists($tenant->databaseConfig()->name())) {
            return;
        }

        $this->database()->transaction(function () use ($tenant) {
            $this->dropUser($tenant);
            $this->dropDatabase($tenant);
        });

        return $next($tenant);
    }

    protected function database(): ConnectionInterface
    {
        return DB::connection($this->connection);
    }

    public function dropDatabase(Tenant $tenant): bool
    {
        if (app()->runningUnitTests()) {
            return false;
        }

        if (! $this->config->get('tenant.drop_database')) {
            return false;
        }

        $database = $tenant->databaseConfig()->name();

        return $this->database()->statement("DROP DATABASE IF EXISTS `{$database}`");
    }

    public function databaseExists(string $name): bool
    {
        if (app()->runningUnitTests()) {
            return false;
        }

        return (bool)$this->database()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'");
    }

    public function dropUser(Tenant $tenant): bool
    {
        $username = $tenant->databaseConfig()->username();
        $host = $tenant->databaseConfig()->host();

        return $this->database()->statement("DROP USER IF EXISTS `{$username}`@'{$host}'");
    }
}
