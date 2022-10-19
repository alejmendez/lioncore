<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Property::truncate();

        Property::create([
            'name'  => 'userStatus',
            'value' => $this->toValueLabel([
                'active',
                'blocked',
                'deactivated',
            ])
        ]);

        Property::create([
            'name'  => 'userLangs',
            'value' => $this->toValueLabel([
                'english',
                'spanish',
                'french',
                'russian',
                'german',
                'arabic',
                'sanskrit',
            ])
        ]);
    }

    public function toValueLabel($arr)
    {
        return collect($arr)->map(function ($element, $key) {
            return [
                'value' => $element,
                'label' => Str::ucfirst($element),
            ];
        })->toJson();
    }
}
