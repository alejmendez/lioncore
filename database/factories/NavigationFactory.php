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
            'title' => $this->faker->text(120),
            'subtitle' => $this->faker->text(120),
            'type' => $this->faker->randomElement(['aside', 'basic', 'collapsable', 'divider', 'group', 'spacer']),
            'tooltip' => $this->faker->text(120),
            'link' => $this->faker->text(120),
            'icon' => $this->faker->text(120),
            'parent' => $this->faker->uuid,
            'order' => $this->faker->numberBetween(0, 30),
            'meta' => $this->faker->text(120),
        ];
    }
}
