<?php
use App\Models\Property;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'name'  => $faker->unique()->word,
        'value' => $faker->unique()->word,
    ];
});
