<?php

use Faker\Generator as Faker;

$factory->define(App\Actor::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstName($gender = 'male'|'female'),
        'apellidos' => $faker->lastName(),
        'pais' => $faker->country(),
    ];
});
