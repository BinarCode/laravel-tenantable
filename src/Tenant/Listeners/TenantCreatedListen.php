<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use App\Events\TenantCreated;
use App\Events\TenantCreationDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Routing\Pipeline;

class TenantCreatedListen
{
    public function handle(TenantCreated $event)
    {
        (new Pipeline(app()))
            ->send($event->tenant)
            ->via('__invoke')
            ->through(
                config('tenant.created_pipeline')
            )->then(fn (Tenant $tenant) => event(new TenantCreationDone($tenant)));
    }
}
