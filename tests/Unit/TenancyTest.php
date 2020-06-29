<?php

namespace Tests\Unit;

use Tests\TestCase;
use URL;

class TenancyTest extends TestCase
{
    /** @test */
    public function tenant_is_the_default_database_connection()
    {
        $this->assertEquals('tenant', config('database.default'));
    }

    /** @test */
    public function tenant_is_set()
    {
        $this->freshLandlordDb();
        $tenant_one = $this->createTenant('One');
        $this->migrateTenant($tenant_one->id);

        $this->assertEquals(app(config('multitenancy.current_tenant_container_key'))->name, 'One');
        $this->assertEquals(app(config('multitenancy.current_tenant_container_key'))->domain, 'one.tenancytest.test');
        $this->assertEquals(app(config('multitenancy.current_tenant_container_key'))->database, 'mt_test_one');
    }

    /** @test */
    public function tenancy_is_working()
    {
        $this->freshLandlordDb();
        $tenant_one = $this->createTenant('One');
        $this->migrateTenant($tenant_one->id);

        URL::forceRootUrl('https://one.tenancytest.test');
        $response = $this->get('/');
        $response->assertStatus(200); // --> Works

        URL::forceRootUrl('https://doesnotexist.tenancytest.test');
        $response = $this->get('/');
        $response->assertStatus(500); // --> Fails: Expected status code 500 but received 200.
    }
}
