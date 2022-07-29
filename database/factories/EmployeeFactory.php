<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Employee;
use App\Models\Person;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        $person = Person::factory()->create();

        return [
            'code' => fake()->randomLetter . fake()->numberBetween(1, 500),
            'position' => fake()->word(),
            'group_id' => fake()->uuid(),
            'date_admission' => fake()->date('Y-m-d', '-5 years'),
            'salary' => fake()->numberBetween(500000, 3000000),
            'person_id' => $person->id,
        ];
    }
}
