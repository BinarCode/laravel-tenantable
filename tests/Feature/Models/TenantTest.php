<?php

namespace BinarCode\Tenantable\Tests\Feature\Models;

use BinarCode\Tenantable\Models\TenantContract;
use BinarCode\Tenantable\Tests\TestCase;

class TenantTest extends TestCase
{
    public function test_it_can_create_a_model()
    {
        /** * @var TenantContract $tenant */
        $tenant = TenantContract::create([
            'name' => 'Binar Code Building',
            'subdomain' => 'sample',
        ]);

        $this->assertCount(1, TenantContract::get());
        $this->assertEquals('Binar Code Building', $tenant->name);
    }
}
