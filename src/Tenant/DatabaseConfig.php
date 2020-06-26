<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Make;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\App;

class DatabaseConfig implements Contracts\DatabaseConfig
{
    use Make;

    /**
     * @var Tenantable
     */
    private Tenantable $tenant;
    /**
     * @var Repository
     */
    private Repository $config;

    public function __construct(Tenantable $tenant)
    {
        $this->tenant = $tenant;
        $this->config = app(Repository::class);
    }

    public function name(): string
    {
        if (App::runningUnitTests()) {
            return ':memory:';
        }

        return $this->tenant->databaseConfig()->name();
    }

    public function username(): ?string
    {
        return $this->tenant->key() ? 'construction_' . $this->tenant->key() : null;
    }

    public function password(): ?string
    {
        return $this->tenant->key() ? 'construction_' . $this->tenant->key() : null;
    }

    public function connection(): string
    {
        return $this->tenant->getConnectionName();
    }

    public function host(): ?string
    {
        return $this->config->get('database.connections.tenant.host');
    }
}
