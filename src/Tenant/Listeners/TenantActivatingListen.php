<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use BinarCode\Tenantable\Events\TenantActivating;
use BinarCode\Tenantable\Events\TenantActivationDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Routing\Pipeline;

class TenantActivatingListen
{
    public function handle(TenantActivating $event)
    {
        (new Pipeline(app()))
            ->send($event->tenant)
            ->via('__invoke')
            ->through(
                config('tenantable.activating_pipeline')
            )->then(fn (Tenantable $tenant) => event(new TenantActivationDone($tenant)));
    }
}
