<?php

namespace BinarCode\Tenantable;

use Illuminate\Support\ServiceProvider;

class TenantableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tenantable.php' => config_path('tenantable.php'),
            ], 'config');

            if (! class_exists('CreatePackageTables')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_tenantable_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_tenantable_tables.php'),
                ], 'migrations');
            }

            $this->commands([]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tenantable.php', 'tenantable');
    }
}
