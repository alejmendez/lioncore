<?php
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Models\Person;
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
    $email = $faker->unique()->safeEmail;
    $username = explode('@', $email);
    $username = $username[0];

    return [
        'person_id' => Person::inRandomOrder()->first()->id,
        'email' => $email,
        'email_verified_at' => $faker->dateTime(),
        'password' => Str::random(16),
        'verification_token' => Str::random(64),
        'username' => $username,
        'status' => $faker->randomElement(['active', 'blocked', 'deactivated']),
    ];
});
