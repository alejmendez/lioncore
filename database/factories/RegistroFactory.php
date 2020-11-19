<?php
use App\Models\Registro;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Registro::class, function (Faker $faker) {
    return [
        "title" => $faker->text,
        "tutor" => $faker->firstName . " " . $faker->lastName,
        "consultancies" => $faker->randomElement([false, true]),
        "documentation" => $faker->randomElement([false, true]),
        "assignedDate" => $faker->randomElement([false, true]),
        "presentation" => $faker->randomElement([false, true]),
        "finalTome" => $faker->randomElement([false, true]),
    ];
});
