<?php

namespace BinarCode\Tenantable\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetupCommand extends Command
{
    protected $signature = 'tenantable:setup';

    protected $description = 'It will setup tenantable application for you.';

    public function handle()
    {
        $this->comment('Publishing Tenantable Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'tenantable-provider']);


        $this->comment('Publishing Tenantable Config...');
        $this->callSilent('vendor:publish', ['--tag' => 'tenantable-config']);

        $this->comment('Publishing Tenantable Migrations...');
        $this->call('vendor:publish', [
            '--tag' => 'tenantable-migrations',
        ]);

        $this->registerServiceProvider();

        $this->info('Tenantable setup successfully.');
    }

    protected function registerServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class," . PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class," . PHP_EOL . "        {$namespace}\Providers\TenantableApplicationServiceProvider::class," . PHP_EOL,
            file_get_contents(config_path('app.php'))
        ));
    }
}
