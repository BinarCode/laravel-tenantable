<?php

namespace BinarCode\Tenantable\Commands;

use BinarCode\Tenantable\Models\Tenant;
use Illuminate\Console\Command;

class TenantsMigrateCommand extends Command
{
    protected $signature = 'tenants:migrate {tenant?} {--fresh} {--seed}';

    public function handle()
    {
        if ($this->argument('tenant')) {
            $this->migrate(
                Tenant::find($this->argument('tenant'))
            );
        } else {
            Tenant::all()->each(
                fn ($organization) => $this->migrate($organization)
            );
        }
    }

    public function migrate($tenant)
    {
        $tenant->makeCurrent();

        $this->line('');
        $this->line('----------------------------------------------');
        $this->info("Migrating Tenant #{$tenant->id} ({$tenant->name})");
        $this->line('----------------------------------------------');

        $options = ['--force' => true,];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call(
            $this->option('fresh') ? 'migrate:fresh' : 'migrate',
            $options,
        );
    }
}
