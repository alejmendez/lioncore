<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Person;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $person = Person::factory()->create();

        $email = $person->email;
        $username = explode('@', $email);
        $username = $username[0];

        return [
            'person_id' => $person->id,
            'email' => $email,
            'email_verified_at' => $this->faker->dateTime(),
            'password' => Str::random(16),
            'verification_token' => Str::random(64),
            'username' => $username,
            'status' => $this->faker->randomElement(['active', 'blocked', 'deactivated']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
