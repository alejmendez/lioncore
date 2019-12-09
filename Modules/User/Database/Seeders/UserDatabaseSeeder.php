<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\User\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // User::truncate();

        $user = User::create([
            'email' => 'admin@test.cl',
            'password' => '1234',
            'name' => 'Administrator',
            'verification_token' => '',
            'email_verified_at' => now(),
        ]);

        $roleAdmin = Role::findByName('admin');
        $user->assignRole($roleAdmin);

        $user = User::create([
            'email' => 'alejmendez.87@gmail.com',
            'password' => 'cq43351la',
            'name' => 'Alejandro Méndez',
            'verification_token' => '',
            'email_verified_at' => now(),
        ]);
        $user->assignRole($roleAdmin);
    }
}
