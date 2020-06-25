<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use BinarCode\Tenantable\Events\TenantDeleted;
use BinarCode\Tenantable\Events\TenantDeletionDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Routing\Pipeline;

class TenantDeletedListen
{
    public function handle(TenantDeleted $event)
    {
        (new Pipeline(app()))
            ->send($event->tenant)
            ->via('__invoke')
            ->through(
                config('tenantable.deleted_pipeline')
            )->then(fn (Tenant $tenant) => event(new TenantDeletionDone($tenant)));
    }
}
