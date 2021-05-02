<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
            'value' => json_encode([
                [
                    'value' => 'active',
                    'label' => 'Active'
                ],
                [
                    'value' => 'blocked',
                    'label' => 'Blocked'
                ],
                [
                    'value' => 'deactivated',
                    'label' => 'Deactivated'
                ]
            ])
        ]);

        Property::create([
            'name'  => 'userLangs',
            'value' => json_encode([
                [
                    'value' => 'english',
                    'label' => 'English'
                ],
                [
                    'value' => 'spanish',
                    'label' => 'Spanish'
                ],
                [
                    'value' => 'french',
                    'label' => 'French'
                ],
                [
                    'value' => 'russian',
                    'label' => 'Russian'
                ],
                [
                    'value' => 'german',
                    'label' => 'German'
                ],
                [
                    'value' => 'arabic',
                    'label' => 'Arabic'
                ],
                [
                    'value' => 'sanskrit',
                    'label' => 'Sanskrit'
                ]
            ])
        ]);
    }
}
