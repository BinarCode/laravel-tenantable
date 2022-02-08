<?php

namespace BinarCode\Tenantable\Http\Middleware;

use BinarCode\Tenantable\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidTenantSession
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->getHost() === config('tenantable.master_fqdn')) {
            return $next($request);
        }

        $sessionKey = 'ensure_valid_tenant_session_tenant_id';

        /** * @var Tenant $tenant */
        $tenant = app(config('tenantable.container_key'));

        if (! $request->session()->has($sessionKey)) {
            $request->session()->put($sessionKey, $tenant->key());

            return $next($request);
        }

        if ($request->session()->get($sessionKey) !== $tenant->key()) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
