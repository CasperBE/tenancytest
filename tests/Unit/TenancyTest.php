<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Spatie\Multitenancy\Models\Tenant;
use Tests\TestCase;

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

        $currentTenant = Tenant::where('domain', 'one.tenancytest.test')->first();
        $currentTenant->makeCurrent();

        $response = $this->get('/');
        $response->assertStatus(200);

        $currentTenant->forgetCurrent();
        session()->flush();

        Config::set('app.url', 'https://doesnotexist.tenancytest.test');
        URL::forceRootUrl('https://doesnotexist.tenancytest.test');

        $response = $this->get('/');
        $response->assertStatus(500);
    }
}
