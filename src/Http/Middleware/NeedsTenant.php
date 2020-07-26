<?php

namespace BinarCode\Tenantable\Http\Middleware;

use BinarCode\Tenantable\Exceptions\MissingTenant;
use Closure;

class NeedsTenant
{
    public function handle($request, Closure $next)
    {
        if (! tenant()->check()) {
            return $this->handleInvalidRequest();
        }

        return $next($request);
    }

    public function handleInvalidRequest(): void
    {
        throw MissingTenant::make();
    }
}
