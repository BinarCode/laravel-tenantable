<?php

namespace BinarCode\Tenantable\Tenant;

use App\Exceptions\InvalidSubdomain;
use BinarCode\Tenantable\Tenant\Contracts\Tenant;
use Binaryk\LaravelRestify\Traits\Make;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubdomainFinder implements Contracts\TenantFinder
{
    use Make;

    /**
     * The index of the subdomain fragment in the hostname
     * split by `.`. 0 for first fragment, 1 if you prefix
     * your subdomain fragments with `www`.
     *
     * @var int
     */
    public static $subdomainIndex = 0;

    /**
     * @var Request
     */
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Tenant|null
     * @throws InvalidSubdomain
     */
    public function __invoke(): ?Tenant
    {
        $tenant = app(Tenant::class)
            ->where('subdomain', $actual = $this->subdomain($this->request))
            ->first();

        if (! $tenant) {
            throw InvalidSubdomain::make($actual);
        }

        return $tenant;
    }

    public function subdomain(Request $request): ?string
    {
        $hostname = $request->getHost();

        $parts = explode('.', $hostname);

        // If we're on localhost or an IP address, then we're not visiting a subdomain.
        $notADomain = in_array(count($parts), [1, 5]); //@todo - why is this?
        $thirdPartyDomain = ! Str::endsWith($hostname, config('tenant.master_domain'));
        ;
        $isMaster = config('tenant.master_domain') === $hostname;

        if ($notADomain || $thirdPartyDomain || $isMaster) {
            return null;
        }

        return $parts[static::$subdomainIndex];
    }
}
