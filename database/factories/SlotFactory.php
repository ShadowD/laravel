<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Slot::class, function (Faker $faker) {
    return [
        'start' => str_pad(rand(7,12), 2, 0, STR_PAD_LEFT) . ':00:00',
        'end'   => rand(14,22) . ':00:00',
    ];
});
