<?php

namespace BinarCode\Tenantable\Commands;

use BinarCode\Tenantable\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MasterMigrate extends Command
{
    use ConfirmableTrait;

    protected $signature = 'master:migrate:fresh {--seed} {--force}';

    protected $description = 'This command run migrations/seeds commands for the master.';

    public function handle()
    {
        DB::purge('master');
        DB::reconnect('master');

        $this->confirmToProceed();

        $options = [
            '--database' => config('tenant.master_database_connection_name'),
            '--realpath' => config('tenant.master_migrations_path'),
            '--path' => config('tenant.master_migrations_path'),
            '--seed' => $this->option('seed'),
            '--force' => $this->option('force'),
        ];

        if (! $this->option('force')) {
            if (! App::runningUnitTests()) {
                if (! $this->confirm('Create databases?')) {
                    Tenant::unsetEventDispatcher();
                }
            }
        }

        if ($this->option('force')) {
            config([
                'tenant.override_existing_database' => true,
            ]);
        }

        Artisan::call("migrate:fresh", $options, $this->output);
    }
}
