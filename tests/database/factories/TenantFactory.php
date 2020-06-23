<?php

use BinarCode\Tenantable\Models\Tenant;
use \Faker\Generator;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Tenant::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'subdomain' => $faker->word,
    ];
});
