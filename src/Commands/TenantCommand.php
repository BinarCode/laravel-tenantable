<?php

namespace BinarCode\Tenantable\Commands;

use BinarCode\Tenantable\Tenant\Contracts\Tenantable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class TenantCommand extends Command
{
    protected $signature = 'tenant {artisanCommand?} {--tenant=*} {--force}';

    protected $description = 'Run a command for a tenant.';

    public function handle()
    {
        /** * @var Builder $query */
        $query = app(Tenantable::class);

        $query = $query->query();

        if (! $tenantId = $this->option('tenant')) {
            if (! $this->option('force')) {
                if (! App::runningUnitTests()) {
                    $tenantId = $this->ask('What tenant ID? Nothing for all tenants.');
                }
            }
        }

        if ($tenantId) {
            $query->whereIn('id', Arr::wrap($tenantId));
        }

        $query->cursor()
            ->each(
                fn (Tenantable $tenant) => $this->forTenant(
                    $tenant->makeCurrent(),
                    $this->argument('artisanCommand') ?? $this->ask('Command to run?')
                )
            );
    }

    protected function forTenant(Tenantable $tenant, string $command): void
    {
        // in case the command passed was: php artisan migrate (not just 'migrate')
        $command = trim(Str::after($command, 'artisan'));

        $this->line('');
        $this->line('----------------------------------------------');
        $this->info("Run [{$command}] for Tenant #{$tenant->key()})");
        $this->line('----------------------------------------------');

        Artisan::call($command, [], $this->output);
    }
}
