<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface Tenant
{
    /**
     * Used for unique identifies, as database name
     *
     * @return string
     */
    public function key(): ?string;

    public static function check(): bool;

    public static function current(): ?Tenant;

    public static function isMaster(): bool;

    public function makeCurrent(): Tenant;

    public function makeCurrentMaster();

    public function isActive(): bool;

    public function forget(): Tenant;

    public function getConnectionName();

    public function databaseConfig(): DatabaseConfig;
}
