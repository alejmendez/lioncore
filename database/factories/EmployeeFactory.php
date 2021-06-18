<?php
namespace Database\Factories;

use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(5000000, 30000000),
            'position' => $this->faker->numberBetween(5000000, 30000000),
            'group_id' => $this->faker->numberBetween(5000000, 30000000),
            'date_admission' => $this->faker->numberBetween(5000000, 30000000),
            'salary' => $this->faker->numberBetween(5000000, 30000000),
        ];
    }
}
