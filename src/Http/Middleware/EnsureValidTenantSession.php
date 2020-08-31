<?php

namespace BinarCode\Tenantable\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidTenantSession
{
    public function handle($request, Closure $next)
    {
        if ($isMasterDomain = config('tenantable.master_fqdn')) {
            return $next($request);
        }

        $sessionKey = 'ensure_valid_tenant_session_tenant_id';

        if (! $request->session()->has($sessionKey)) {
            $request->session()->put($sessionKey, app(config('tenantable.container_key', 'organization'))->id);

            return $next($request);
        }

        if ($request->session()->get($sessionKey) !== app(config('tenantable.container_key', 'organization'))->id) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
