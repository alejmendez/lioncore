<?php
use App\Models\Alumno;
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

$factory->define(Alumno::class, function (Faker $faker) {
    return [
        "firstName" => $faker->firstName,
        "lastname" => $faker->lastName,
        "phone" => $faker->phoneNumber,
        "email" => $faker->unique()->safeEmail,
        "specialty" => $faker->randomElement(['Sistemas', 'Informática', 'Mantenimiento', 'Ambiental']),
        "semester" => $faker->randomElement(['I-2016', 'II-2016', 'I-2017', 'II-2017', 'I-2018', 'II-2018', 'I-2019', 'II-2019', 'I-2020', 'II-2020']),
    ];
});
