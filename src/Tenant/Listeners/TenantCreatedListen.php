<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use BinarCode\Tenantable\Events\TenantCreated;
use BinarCode\Tenantable\Events\TenantCreationDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Routing\Pipeline;

class TenantCreatedListen
{
    public function handle(TenantCreated $event)
    {
        (new Pipeline(app()))
            ->send($event->tenant)
            ->via('__invoke')
            ->through(
                config('tenantable.created_pipeline')
            )->then(fn (Tenantable $tenant) => event(new TenantCreationDone($tenant)));
    }
}
