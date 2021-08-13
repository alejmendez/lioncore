<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Navigation;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Navigation::truncate();
        $adminGroup = Navigation::create([
            'title'    => 'Admin',
            'subtitle' => 'Admin',
            'type'     => 'group',
            'order'    => 0,
            'icon'     => 'heroicons_outline:home'
        ]);

        Navigation::create([
            'title'    => 'Usuarios',
            'type'     => 'basic',
            'icon'     => 'heroicons_outline:clipboard-check',
            'link'     => '/admin/users',
            'order'    => 0,
            'parent'   => $adminGroup->id
        ]);

        Navigation::create([
            'title'    => 'Perfiles',
            'type'     => 'basic',
            'icon'     => 'heroicons_outline:clipboard-check',
            'link'     => '/admin/roles',
            'order'    => 1,
            'parent'   => $adminGroup->id
        ]);
    }
}
