<?php

namespace BinarCode\Tenantable;

trait Make
{
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    public static function new(...$arguments)
    {
        return new static(...$arguments);
    }
}
