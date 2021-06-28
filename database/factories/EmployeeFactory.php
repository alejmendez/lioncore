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
            'code' => $this->faker->randomLetter . $this->faker->numberBetween(1, 500),
            'position' => $this->faker->word(),
            'group_id' => $this->faker->Uuid(),
            'date_admission' => $this->faker->date('Y-m-d', '-5 years'),
            'salary' => $this->faker->numberBetween(500000, 3000000),
            'person_id' => $person->id,
        ];
    }
}
