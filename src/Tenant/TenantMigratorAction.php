<?php

namespace BinarCode\Tenantable\Tenant;

use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Support\Facades\Artisan;

class TenantMigratorAction
{
    public static function invoke(Tenantable $tenant)
    {
        return Artisan::call('tenant', [
            'artisanCommand' => 'migrate:fresh --seed',
            '--tenant' => $tenant->key(),
            '--force' => true,
        ]);
    }
}
