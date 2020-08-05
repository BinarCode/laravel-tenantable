<?php

namespace BinarCode\Tenantable;

use BinarCode\Tenantable\Models\BelongsToTenant;

class Tenantable
{
    public static function useColumn(string $column): void
    {
        BelongsToTenant::$tenantIdColumn = $column;
    }
}
