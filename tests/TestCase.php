<?php

namespace BinarCode\Tenantable\Tests;

use BinarCode\Tenantable\TenantableServiceProvider;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithLaravelMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            TenantableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'master');

        $app['config']->set('database.connections.master', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('tenantable.master_database_connection_name', 'master');
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_tenantable_tables.php.stub';

        (new \CreateTenantableTables())->up();
    }
}
