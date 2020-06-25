<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use App\Events\TenantActivating;
use App\Events\TenantCreationDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Routing\Pipeline;

class TenantActivatingListen
{
    public function handle(TenantActivating $event)
    {
        (new Pipeline(app()))
            ->send($event->tenant)
            ->via('__invoke')
            ->through(
                config('tenant.activating_pipeline')
            )->then(fn (Tenant $tenant) => event(new TenantCreationDone($tenant)));
    }
}
