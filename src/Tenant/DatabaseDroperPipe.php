<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Config\Repository;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\App;
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
        $this->connection = $config->get('tenantable.master_database_connection_name');
    }

    public function __invoke(Tenantable $tenant, callable $next)
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

    public function dropDatabase(Tenantable $tenant): bool
    {
        if (App::runningInConsole()) {
            return false;
        }

        if (! $this->config->get('tenantable.drop_database')) {
            return false;
        }

        $database = $tenant->databaseConfig()->name();

        return $this->database()->statement("DROP DATABASE IF EXISTS `{$database}`");
    }

    public function databaseExists(string $name): bool
    {
        if (App::runningUnitTests()) {
            return false;
        }

        return (bool)$this->database()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'");
    }

    public function dropUser(Tenantable $tenant): bool
    {
        $username = $tenant->databaseConfig()->username();
        $host = $tenant->databaseConfig()->host();

        return $this->database()->statement("DROP USER IF EXISTS `{$username}`@'{$host}'");
    }
}
