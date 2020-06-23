<?php

namespace BinarCode\Tenantable\Tests\Feature\Models;

use BinarCode\Tenantable\Models\Tenant;
use BinarCode\Tenantable\Tests\TestCase;

class TenantTest extends TestCase
{
    public function test_it_can_create_a_model()
    {
        /** * @var Tenant $tenant */
        $tenant = Tenant::create([
            'name' => 'Binar Code Building',
            'subdomain' => 'sample',
        ]);

        $this->assertDatabaseCount('tenants', 1);
        $this->assertEquals('Binar Code Building', $tenant->name);
    }
}
