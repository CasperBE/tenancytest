<?php

namespace App\Tasks;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchRouteUrlTask implements SwitchTenantTask
{
    private $originalUrl;

    public function makeCurrent(Tenant $tenant): void
    {
        $this->originalUrl = config('app.url');

        $protocol = Str::before($this->originalUrl, '://');

        Config::set('app.url', "{$protocol}://{$tenant->domain}");
        URL::forceRootUrl(config('app.url'));
    }

    public function forgetCurrent(): void
    {
        Config::set('app.url', $this->originalUrl);
        URL::forceRootUrl($this->originalUrl);
    }
}
