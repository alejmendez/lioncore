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
            "dni" => $faker->sentence,
            "first_name" => $faker->sentence,
            "last_name" => $faker->sentence,
            "address" => $faker->sentence,
            "birthdate" => $faker->sentence,
            "civil_status" => $faker->sentence,
            "room_telephone" => $faker->sentence,
            "mobile_phone" => $faker->sentence,
            "email" => $faker->sentence,
            "nationality" => $faker->sentence,
            "gender" => $faker->sentence,
            "height" => $faker->sentence,
            "weight" => $faker->sentence,
            "shirt_size" => $faker->sentence,
            "size_pants" => $faker->sentence,
            "shoe_size" => $faker->sentence,
            "profession" => $faker->sentence,
            "academic_level" => $faker->sentence,
            "country" => $faker->sentence,
            "state" => $faker->sentence,
            "municipality" => $faker->sentence,
            "parish" => $faker->sentence,
            "military_component" => $faker->sentence,
            "military_rank" => $faker->sentence,
            "number_children" => $faker->sentence,
            "spouse_works" => $faker->sentence,
            "observation" => $faker->sentence,
            "photos" => $faker->sentence,
            "turn" => $faker->sentence,
            "schedule" => $faker->sentence,
            "blood_type" => $faker->sentence,
            "file_number" => $faker->sentence,
            "management" => $faker->sentence,
            "organization_id" => $faker->sentence,
            ];
});
