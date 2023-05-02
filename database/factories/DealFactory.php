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

$factory->define(App\Deal\Deal::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'case_id' => $faker->shuffleString($faker->word()),
    ];
});
