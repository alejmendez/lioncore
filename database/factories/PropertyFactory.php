<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Property;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        $property = $this->faker->unique()->word . $this->faker->numberBetween(1, 999999);
        $slug = Str::slug($property, '-');

        return [
            'name'  => $slug,
            'value' => $property,
        ];
    }
}
