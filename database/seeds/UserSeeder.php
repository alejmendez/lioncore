<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Person;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::truncate();

        $person = factory(Person::class)->create();
        $person->fill([
            'dni' => '19',
            'first_name' => 'Administrador',
            'last_name' => '',
            'email' => 'admin@test.cl',
        ]);
        $person->save();

        $user = User::create([
            'person_id' => $person->id,
            'email' => $person->email,
            'password' => 'cq43351la',
            'verification_token' => '',
            'email_verified_at' => now(),
            'username' => 'admin',
            'status' => 'active',
        ]);

        $roleAdmin = Role::findByName('admin');
        $user->assignRole($roleAdmin);

        $person = factory(Person::class)->create();
        $person->fill([
            'dni' => '266046677',
            'first_name' => 'Alejandro',
            'last_name' => 'Méndez',
            'email' => 'alejmendez.87@gmail.com',
        ]);
        $person->save();
        $user = User::create([
            'person_id' => $person->id,
            'email' => $person->email,
            'password' => 'cq43351la',
            'verification_token' => '',
            'email_verified_at' => now(),
            'username' => 'alejmendez',
            'status' => 'active',
        ]);
        $user->assignRole($roleAdmin);

        factory(User::class, 3)->create();
    }
}
