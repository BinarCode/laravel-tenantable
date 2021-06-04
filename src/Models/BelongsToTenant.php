<?php

namespace BinarCode\Tenantable\Models;

/**
 * Trait BelongsToTenant
 * @package BinarCode\Tenantable\Models
 * @author @stancl https://tenancyforlaravel.com/docs/v3/single-database-tenancy
 */
trait BelongsToTenant
{
    public function tenant()
    {
        return $this->belongsTo(config('tenantable.model'), config('tenantable.related_tenant_column'));
    }

    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (! $model->getAttribute(config('tenantable.related_tenant_column')) && ! $model->relationLoaded('tenant')) {
                if (tenant()->check()) {
                    $model->setAttribute(config('tenantable.related_tenant_column'), tenant()->key());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }
}
