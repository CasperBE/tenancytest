<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Spatie\Multitenancy\Models\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    $name = $faker->slug(1, false);

    return [
        'name' => $name,
        'domain' => $name.'.tenancytest.test',
        'database' => 'mt_test',
    ];
});
