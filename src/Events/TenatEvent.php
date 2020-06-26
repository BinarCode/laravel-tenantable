<?php

namespace BinarCode\Tenantable\Events;

use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Queue\SerializesModels;

class TenatEvent
{
    use SerializesModels;

    /** * @var Tenantable */
    public Tenantable $tenant;

    public function __construct(Tenantable $tenant)
    {
        $this->tenant = $tenant;
    }
}
