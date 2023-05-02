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

$factory->define(App\Users\User::class, function (Faker $faker) {
    static $password;
    $role_seller = App\Users\Roles\Role::where('name', 'Seller')->first();

    return [
        'name' => $faker->name,
        'contact_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'role_id' => $role_seller->id
    ];
});
