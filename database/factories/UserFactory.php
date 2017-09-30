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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Root::class, function (Faker $faker) {
    return [
        'id' => $faker->regexify('^\d{10}$'),
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'correoElectronico' => 'root@root.com',
        'contraseña' => bcrypt('Root1234')
    ];
});

$factory->define(App\Models\Administrador::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->regexify('^\d{10}$'),
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'correoElectronico' => $faker->unique()->safeEmail,
        'contraseña' => bcrypt(str_random(10)),
        'telefono' => $faker->regexify('^\d{7,10}$')
    ];
});
