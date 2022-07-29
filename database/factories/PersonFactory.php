<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Person;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition()
    {
        $firstName = fake()->firstName;
        $lastName = fake()->lastName;
        $username = Str::slug($firstName) . '.' . Str::slug($lastName) . fake()->numberBetween(1, 99999);
        $email    = $username . '@gmail.com';

        return [
            'dni'             => fake()->numberBetween(5000000, 30000000),
            'first_name'      => $firstName,
            'last_name'       => $lastName,
            'avatar'          => fake()->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate'       => fake()->date('Y-m-d', '-18 years'),
            'room_telephone'  => fake()->phoneNumber,
            'mobile_phone'    => fake()->phoneNumber,
            'website'         => '',
            'languages'       => fake()->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
            'email'           => $email,
            'nationality'     => fake()->randomElement(['C', 'E']),
            'gender'          => fake()->randomElement(['male', 'female', 'other']),
            'civil_status'    => fake()->randomElement(['C', 'S', 'D', 'V']),
            'contact_options' => fake()->randomElement(['email', 'message', 'phone']),
            'address'         => fake()->address,
            'address2'        => fake()->secondaryAddress,
            'postcode'        => fake()->postcode,
            'city'            => fake()->city,
            'state'           => fake()->state,
            'country'         => fake()->country,
            'number_children' => fake()->numberBetween(0, 5),
            'observation'     => fake()->text(250),
            'about'           => fake()->text(250),
            'blood_type'      => fake()->text(5),
        ];
    }
}
