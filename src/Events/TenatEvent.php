<?php

namespace BinarCode\Tenantable\Events;

use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Queue\SerializesModels;

class TenatEvent
{
    use SerializesModels;

    /** * @var Tenant */
    public Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }
}
