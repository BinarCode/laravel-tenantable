<?php

namespace BinarCode\Tenantable\Tenant\Contracts;

interface DatabaseConfig
{
    public function name(): string;

    public function username(): ?string;

    public function password(): ?string;

    public function connection(): string;

    public function host(): ?string;
}
