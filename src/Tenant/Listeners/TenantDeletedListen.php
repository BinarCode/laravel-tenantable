<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use BinarCode\Tenantable\Events\TenantDeleted;
use BinarCode\Tenantable\Events\TenantDeletionDone;
use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
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
            )->then(fn (Tenantable $tenant) => event(new TenantDeletionDone($tenant)));
    }
}
