<?php
use Modules\User\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
            "person_id" => $faker->number,
            "email" => $faker->unique()->safeEmail,
            "email_verified_at" => $faker->datetimestamp,
            "password" => $faker->randomElement(['M', 'F']),
            "verification_token" => $faker->numberBetween(150, 210),
            ];
});
