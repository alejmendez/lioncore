<?php
use Modules\core\Models\Person;
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
            "address" => $faker->address,
            "birthdate" => $faker->date('Y-m-d', '-18 years') ,
            "civil_status" => $faker->randomElement(['C', 'S', 'D', 'V']),
            "room_telephone" => $faker->phoneNumber,
            "mobile_phone" => $faker->phoneNumber,
            "email" => $faker->unique()->safeEmail,
            "nationality" => $faker->randomElement(['C', 'E']),
            "gender" => $faker->randomElement(['M', 'F']),
            "height" => $faker->numberBetween(150, 210),
            "weight" => $faker->numberBetween(48, 130),
            "shirt_size" => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XL']),
            "size_pants" => $faker->numberBetween(30, 54),
            "shoe_size" => $faker->numberBetween(28, 54),
            "profession" => $faker->word,
            "academic_level" => $faker->word,
            "country" => $faker->country,
            "state" => $faker->state,
            "municipality" => $faker->city,
            "parish" => $faker->word,
            "military_component" => $faker->word,
            "military_rank" => $faker->word,
            "number_children" => $faker->numberBetween(0, 5),
            "spouse_works" => $faker->word,
            "observation" => $faker->text(250),
            "photos" => $faker->imageUrl(500, 500, 'people', true, 'Faker'),
            "turn" => $faker->word,
            "schedule" => $faker->word,
            "blood_type" => $faker->text(5),
            "file_number" => $faker->word,
            "management" => $faker->word,
            "organization_id" => $faker->word,
            ];
});
