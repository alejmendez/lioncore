<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Core\Models\Person;
use Modules\Role\Models\Role;
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

        $person = Person::create([
            'dni' => '19',
            'first_name' => 'Administrador',
            'email' => 'admin@test.cl',
        ]);

        $user = User::create([
            'person_id' => $person->id,
            'email' => $person->email,
            'password' => '1234',
            'verification_token' => '',
            'email_verified_at' => now(),
        ]);

        $roleAdmin = Role::findByName('admin');
        $user->assignRole($roleAdmin);

        $person = Person::create([
            'dni' => '266046677',
            'first_name' => 'Alejandro Méndez',
            'email' => 'alejmendez.87@gmail.com',
        ]);
        $user = User::create([
            'person_id' => $person->id,
            'email' => $person->email,
            'password' => 'cq43351la',
            'verification_token' => '',
            'email_verified_at' => now(),
        ]);
        $user->assignRole($roleAdmin);
    }
}
