<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Make;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Contracts\Config\Repository;

class DatabaseConfig implements Contracts\DatabaseConfig
{
    use Make;

    /**
     * @var Tenant
     */
    private Tenant $tenant;
    /**
     * @var Repository
     */
    private Repository $config;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
        $this->config = app(Repository::class);
    }

    public function name(): string
    {
        if (app()->runningUnitTests()) {
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
