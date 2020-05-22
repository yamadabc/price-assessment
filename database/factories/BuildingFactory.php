<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use Faker\Generator as Faker;

$factory->define(Building::class, function (Faker $faker) {
    return [
        'building_name' => $faker->secondaryAddress,
        'prefecture' => $faker->prefecture,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'built_year' => $faker->numberBetween(1,50),
        'built_month' => $faker->numberBetween(1,50),
        'total_unit' => $faker->numberBetween(50,100),
        'level_underground' => $faker->numberBetween(0,3),
        'level_floor' => $faker->numberBetween(0,3),
        'construction' => 'RC',
        'station_name_01' => '品川',
        'station_walk_01' => $faker->numberBetween(1,10),
    ];
});
