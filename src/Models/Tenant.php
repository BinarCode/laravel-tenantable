<?php

namespace BinarCode\Tenantable\Models;

use BinarCode\Tenantable\Events\TenantActivating;
use BinarCode\Tenantable\Events\TenantCreated;
use BinarCode\Tenantable\Events\TenantDeleted;
use BinarCode\Tenantable\Events\TenantSaved;
use BinarCode\Tenantable\Events\TenantUpdated;
use BinarCode\Tenantable\Models\Concerns\UsesMasterConnection;
use BinarCode\Tenantable\Tenant\Contracts\DatabaseConfig;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Tenant extends Model implements Tenantable
{
    use UsesMasterConnection;

    public $dispatchesEvents = [
        'created' => TenantCreated::class,
        'deleted' => TenantDeleted::class,
        'saved' => TenantSaved::class,
        'updated' => TenantUpdated::class,
    ];

    protected $guarded = ['id'];


    public function key(): ?string
    {
        return Str::lower(Str::snake($this->getKey()));
    }

    public static function current(): ?Tenant
    {
        $containerKey = config('tenantable.container_key');


        if (! app()->has($containerKey)) {
            return null;
        }

        return app($containerKey);
    }

    public static function check(): bool
    {
        return static::current() instanceof Tenant;
    }

    public static function isMaster(): bool
    {
        return ! static::check();
    }

    public function makeCurrent(): Tenantable
    {
        event(new TenantActivating($this));

        return $this;
    }

    public function makeCurrentMaster()
    {
        tenant()->forget();

        config([
            'database.default' => $this->masterDatabaseConnectionName(),
        ]);

        DB::purge($this->masterDatabaseConnectionName());
        DB::reconnect($this->masterDatabaseConnectionName());
    }

    public function isActive(): bool
    {
        return boolval($this->active);
    }

    public function forget(): Tenantable
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();

        config([
            "database.connections.{$tenantConnectionName}.database" => null,
        ]);

        DB::purge($tenantConnectionName);

        return $this;
    }

    public function databaseConfig(): DatabaseConfig
    {
        return \BinarCode\Tenantable\Tenant\DatabaseConfig::make($this);
    }
}
