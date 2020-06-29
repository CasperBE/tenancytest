<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

Set up testing for spatie/laravel-multitenancy

## Steps

#### Initial commit
- `laravel new tenancytest`

#### Install spatie/laravel-multitenancy
- `composer require "spatie/laravel-multitenancy:^1.0"`
- `php artisan vendor:publish --provider="Spatie\Multitenancy\MultitenancyServiceProvider" --tag="config"`

