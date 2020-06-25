<?php

namespace BinarCode\Tenantable\Tests;

use BinarCode\Tenantable\Models\Tenant;
use BinarCode\Tenantable\TenantableServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
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

        include_once __DIR__.'/../database/migrations/create_tenantable_tables.php.stub';
        (new \CreateTenantableTables())->up();
    }
}
