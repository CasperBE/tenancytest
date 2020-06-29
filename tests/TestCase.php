<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Tenant;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function freshLandlordDb(): self
    {
        $this->artisan('migrate:fresh --database=landlord --path=database/migrations/landlord')->assertExitCode(0);

        return $this;
    }

    protected function createTenant($name): Tenant
    {
        return factory(Tenant::class)->create([
            'name' => $name,
            'domain' => Str::slug($name).'.tenancytest.test',
            'database' => 'mt_test_'.Str::slug($name),
        ]);
    }

    protected function migrateTenant($tenantId): self
    {
        $this->artisan('tenants:artisan "migrate:fresh" --tenant='.$tenantId);

        return $this;
    }
}
