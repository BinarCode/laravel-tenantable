<?php

namespace BinarCode\Tenantable\Tenant\Listeners;

use App\Events\TenantDeleted;
use App\Events\TenantDeletionDone;
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
                config('tenant.deleted_pipeline')
            )->then(fn (Tenant $tenant) => event(new TenantDeletionDone($tenant)));
    }
}
