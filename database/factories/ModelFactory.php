<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Root::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->regexify('^\d{10}$'),
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'correoElectronico' => 'root@root.com',
        'contraseña' => bcrypt('Root1234')
    ];
});

/*$factory->define(App\Models\Usuario::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker-> regexify('^\d{10}$'),
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'tipoUsuario' => $faker->randomElement([''])
        'remember_token' => str_random(10),
    ];
});*/

//['id', 'nombres', 'apellidos', 'correoElectronico', 'contraseña', 'telefono'];
$factory->define(App\Models\Administrador::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->regexify('^\d{10}$'),
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'correoElectronico' => $faker->safeEmail,
        'contraseña' => bcrypt(str_random(10)),
        'telefono' => $faker->regexify('^\d{7,10}$')
    ];
});
