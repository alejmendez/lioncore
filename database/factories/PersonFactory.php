<?php
use App\Models\Person;
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

$factory->define(Person::class, function (Faker $faker) {

    return [
        "dni" => $faker->numberBetween(5000000, 30000000),
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "company" => $faker->company,
        "avatar" => $faker->imageUrl(500, 500, 'people', true, 'Faker'),
        "birthdate" => $faker->date('Y-m-d', '-18 years') ,
        "room_telephone" => $faker->phoneNumber,
        "mobile_phone" => $faker->phoneNumber,
        "website" => '',
        "languages" => $faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
        "email" => $faker->unique()->safeEmail,
        "nationality" => $faker->randomElement(['C', 'E']),
        "gender" => $faker->randomElement(['male', 'female', 'other']),
        "civil_status" => $faker->randomElement(['C', 'S', 'D', 'V']),
        "contact_options" => $faker->randomElement(['email', 'message', 'phone']),
        "address" => $faker->address,
        "address2" => $faker->secondaryAddress,
        "postcode" => $faker->postcode,
        "city" => $faker->city,
        "state" => $faker->state,
        "country" => $faker->country,
        "number_children" => $faker->numberBetween(0, 5),
        "observation" => $faker->text(250),
        "blood_type" => $faker->text(5),
    ];
});
