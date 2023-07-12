<?php

namespace BinarCode\Tenantable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $column = $model->qualifyColumn(config('tenantable.related_tenant_column'));
        $tenantKey = Tenant::check()
            ? tenant()->key()
            : null;

        if (config('tenantable.allow_nullable_tenant')) {
            $builder->where(function (Builder $query) use ($column, $tenantKey) {
                $query->whereNull($column)
                    ->orWhere($column, $tenantKey);
            });
        } else {
            $builder->where($column, $tenantKey);
        }
    }

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenant', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
