<?php

use \Faker\Generator;
use BinarCode\Tenantable\Models\TenantContract;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(TenantContract::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'subdomain' => $faker->word,
    ];
});
