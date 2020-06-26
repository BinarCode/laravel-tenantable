<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface Tenantable
{
    /**
     * Used for unique identifies, as database name
     *
     * @return string
     */
    public function key(): ?string;

    public static function check(): bool;

    public static function current(): ?Tenantable;

    public static function isMaster(): bool;

    public function makeCurrent(): Tenantable;

    public function makeCurrentMaster();

    public function isActive(): bool;

    public function forget(): Tenantable;

    public function getConnectionName();

    public function databaseConfig(): DatabaseConfig;

    public function tenantDatabaseConnectionName(): ?string;

    public function containerKey(): string;
}
