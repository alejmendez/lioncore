<?php

namespace Database\Factories;

use App\Models\Property;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
