<?php

namespace BinarCode\Tenantable\Models;

use Illuminate\Support\Facades\App;

/**
 * Trait BelongsToTenant
 * @package BinarCode\Tenantable\Models
 * @author @stancl https://tenancyforlaravel.com/docs/v3/single-database-tenancy
 */
trait BelongsToTenant
{
    public static $tenantIdColumn = 'tenant_id';

    public function tenant()
    {
        return $this->belongsTo(config('tenantable.model'), BelongsToTenant::$tenantIdColumn);
    }

    public static function bootBelongsToTenant()
    {
        if (! App::runningInConsole()) {
            static::addGlobalScope(new TenantScope);
        }

        static::creating(function ($model) {
            if (! $model->getAttribute(BelongsToTenant::$tenantIdColumn) && ! $model->relationLoaded('tenant')) {
                if (tenant()->check()) {
                    $model->setAttribute(BelongsToTenant::$tenantIdColumn, tenant()->key());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }
}
