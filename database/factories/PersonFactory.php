<?php

namespace Database\Factories;

use App\Models\Person;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $username = $firstName . '.' . $lastName . $this->faker->numberBetween(1, 99999);
        $email    = $username . '@gmail.com';

        return [
            'dni'             => $this->faker->numberBetween(5000000, 30000000),
            'first_name'      => $firstName,
            'last_name'       => $lastName,
            'company'         => $this->faker->company,
            'avatar'          => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate'       => $this->faker->date('Y-m-d', '-18 years'),
            'room_telephone'  => $this->faker->phoneNumber,
            'mobile_phone'    => $this->faker->phoneNumber,
            'website'         => '',
            'languages'       => $this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
            'email'           => $email,
            'nationality'     => $this->faker->randomElement(['C', 'E']),
            'gender'          => $this->faker->randomElement(['male', 'female', 'other']),
            'civil_status'    => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options' => $this->faker->randomElement(['email', 'message', 'phone']),
            'address'         => $this->faker->address,
            'address2'        => $this->faker->secondaryAddress,
            'postcode'        => $this->faker->postcode,
            'city'            => $this->faker->city,
            'state'           => $this->faker->state,
            'country'         => $this->faker->country,
            'number_children' => $this->faker->numberBetween(0, 5),
            'observation'     => $this->faker->text(250),
            'blood_type'      => $this->faker->text(5),
        ];
    }
}
