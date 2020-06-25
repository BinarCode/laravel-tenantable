<?php

namespace BinarCode\Tenantable;

use BinarCode\Tenantable\Commands\MasterMigrate;
use BinarCode\Tenantable\Commands\SetupCommand;
use BinarCode\Tenantable\Commands\TenantCommand;
use BinarCode\Tenantable\Commands\TenantsMigrateCommand;
use Illuminate\Support\ServiceProvider;

class TenantableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tenantable.php' => config_path('tenantable.php'),
            ], 'tenantable-config');

            if (! class_exists('CreatePackageTables')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_tenantable_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_tenantable_tables.php'),
                ], 'tenantable-migrations');
            }

            if (! class_exists('TenantableApplicationServiceProvider')) {
                $this->publishes([
                    __DIR__ . '/Commands/stubs/TenantableApplicationServiceProvider.php.stub' => app_path('Providers/TenantableApplicationServiceProvider.php'),
                ], 'tenantable-provider');
            }


            $this->commands([
                SetupCommand::class,
                MasterMigrate::class,
                TenantCommand::class,
                TenantsMigrateCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tenantable.php', 'tenantable');
    }
}
