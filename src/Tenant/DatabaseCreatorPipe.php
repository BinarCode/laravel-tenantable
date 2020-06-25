<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Exceptions\BecauseDatabase;
use BinarCode\Tenantable\Tenant\Contracts\Pipelineable;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DatabaseCreatorPipe implements Pipelineable
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

    public function __invoke(Tenant $tenant, $next)
    {
        $this->purgeExistingDatabase($tenant, $next);

        if ($this->databaseExists($tenant->databaseConfig()->name())) {
            throw BecauseDatabase::exists($tenant->databaseConfig()->name());
        }

        $this->database()->transaction(function () use ($tenant) {
            $this->createDatabase($tenant);
            $this->createDatabaseUser($tenant);
        });

        return $next($tenant);
    }

    protected function database(): Connection
    {
        return DB::connection($this->connection);
    }

    public function createDatabase(Tenant $tenant): bool
    {
        if (App::runningUnitTests()) {
            return false;
        }

        $database = $tenant->databaseConfig()->name();
        $charset = $this->database()->getConfig('charset');
        $collation = $this->database()->getConfig('collation');

        return $this->database()->statement("CREATE DATABASE `{$database}` CHARACTER SET `{$charset}` COLLATE `{$collation}`");
    }

    public function databaseExists(string $name): bool
    {
        if (App::runningUnitTests()) {
            return false;
        }

        return (bool)$this->database()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'");
    }

    public function createDatabaseUser(Tenant $tenant)
    {
        if ($this->config->get('tenantable.create_database_user')) {
            $privileges = 'ALL';

            $host = $tenant->databaseConfig()->host();
            $database = $tenant->databaseConfig()->name();
            $username = $tenant->databaseConfig()->username();
            $password = $tenant->databaseConfig()->password();


            $this->database()->statement("CREATE USER IF NOT EXISTS `{$username}`@'{$host}' IDENTIFIED BY '{$password}'");


            return $this->database()->statement("GRANT $privileges ON `{$database}`.* TO `{$username}`@'{$host}'");
        }
    }

    public function purgeExistingDatabase(Tenant $tenant, $next)
    {
        if ($this->config->get('tenantable.override_existing_database')) {
            app(DatabaseDroperPipe::class)->__invoke($tenant, $next);
        }
    }
}
