<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantMigratorAction
{
    public static function invoke(Tenant $tenant)
    {
        return Artisan::call('tenant', [
            'artisanCommand' => 'migrate:fresh --seed',
            '--tenant' => $tenant->key(),
            '--force' => true,
        ]);
    }
}
