<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Navigation;

class NavigationFactory extends Factory
{
    protected $model = Navigation::class;

    public function definition()
    {
        return [
            'title' => fake()->text(120),
            'subtitle' => fake()->text(120),
            'type' => fake()->randomElement(['aside', 'basic', 'collapsable', 'divider', 'group', 'spacer']),
            'tooltip' => fake()->text(120),
            'link' => fake()->text(120),
            'icon' => fake()->text(120),
            'parent' => fake()->uuid,
            'order' => fake()->numberBetween(0, 30),
            'meta' => fake()->text(120),
        ];
    }
}
