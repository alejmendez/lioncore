<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Permission;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $permissions = Permission::all()->map(function($permission) {
            return $permission->id;
        });

        $len = fake()->numberBetween(1, 5);
        $permissionsArr = [];
        for ($i=0; $i < $len; $i++) {
            $permissionsArr[] = fake()->randomElement($permissions);
        }

        return [
            'name' => Str::random(8),
            //'permissions' => $permissionsArr,
        ];
    }
}
