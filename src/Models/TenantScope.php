<?php

namespace BinarCode\Tenantable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder
            ->when(config('tenantable.allow_nullable_tenant'), fn(Builder $builder) => $builder->whereNull($model->qualifyColumn(config('tenantable.related_tenant_column'))))
            ->orWhere(
                $model->qualifyColumn(config('tenantable.related_tenant_column')), tenant()->key()
            );
    }

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenant', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
