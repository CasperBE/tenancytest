<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

Set up testing for spatie/laravel-multitenancy

## Steps

#### Initial commit
- `laravel new tenancytest`

#### Install spatie/laravel-multitenancy
- `composer require "spatie/laravel-multitenancy:^1.0"`
- `php artisan vendor:publish --provider="Spatie\Multitenancy\MultitenancyServiceProvider" --tag="config"`

#### Setup multi database tenancy
- add package middleware
- update config/multitenancy for using multiple databases
- add "tenant" and "landlord" connections to config/database (also added corresponding env variables)
- create "mt_landlord" database
- `php artisan vendor:publish --provider="Spatie\Multitenancy\MultitenancyServiceProvider" --tag="migrations"`
- `php artisan migrate --path=database/migrations/landlord --database=landlord`

#### Add testing
- Create "mt_test_one" and "mt_test_two" databases
- Add TenantFactory
- `php artisan make:test TenancyTest --unit`
- Add some methods to TestCase
- Add Unit/TenancyTest with some tests
