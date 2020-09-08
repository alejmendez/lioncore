<?php

use App\Models\Person;
use Faker\Generator as Faker;


$factory->define(Person::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $username = $firstName . '.' . $lastName . $faker->numberBetween(1, 99999);
    $email    = $username . '@gmail.com';

    return [
        'dni'             => $faker->numberBetween(5000000, 30000000),
        'first_name'      => $firstName,
        'last_name'       => $lastName,
        'company'         => $faker->company,
        'avatar'          => $faker->imageUrl(500, 500, 'people', true, 'Faker'),
        'birthdate'       => $faker->date('Y-m-d', '-18 years'),
        'room_telephone'  => $faker->phoneNumber,
        'mobile_phone'    => $faker->phoneNumber,
        'website'         => '',
        'languages'       => $faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
        'email'           => $email,
        'nationality'     => $faker->randomElement(['C', 'E']),
        'gender'          => $faker->randomElement(['male', 'female', 'other']),
        'civil_status'    => $faker->randomElement(['C', 'S', 'D', 'V']),
        'contact_options' => $faker->randomElement(['email', 'message', 'phone']),
        'address'         => $faker->address,
        'address2'        => $faker->secondaryAddress,
        'postcode'        => $faker->postcode,
        'city'            => $faker->city,
        'state'           => $faker->state,
        'country'         => $faker->country,
        'number_children' => $faker->numberBetween(0, 5),
        'observation'     => $faker->text(250),
        'blood_type'      => $faker->text(5),
    ];
});
