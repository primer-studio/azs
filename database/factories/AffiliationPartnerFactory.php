<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\AffiliationPartner::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'status' => 'active',
        'commission_rate' => rand(1,100),
        'username' => $faker->userName,
    ];
});
