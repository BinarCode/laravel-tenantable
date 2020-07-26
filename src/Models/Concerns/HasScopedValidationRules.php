<?php

namespace BinarCode\Tenantable\Models\Concerns;

use BinarCode\Tenantable\Models\BelongsToTenant;

/**
 * @package BinarCode\Tenantable\Models\Concerns;
 * @author @stancl https://tenancyforlaravel.com/docs/v3/single-database-tenancy
 */
trait HasScopedValidationRules
{
    public function unique($table, $column = 'NULL')
    {
        return (new Unique($table, $column))->where(BelongsToTenant::$tenantIdColumn, $this->getTenantKey());
    }

    public function exists($table, $column = 'NULL')
    {
        return (new Exists($table, $column))->where(BelongsToTenant::$tenantIdColumn, $this->getTenantKey());
    }
}
