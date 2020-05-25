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
            'username' => 'admin',
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
            'username' => 'alejmendez',
        ]);
        $user->assignRole($roleAdmin);

        factory(User::class, 100)->create()->each(function($user) {
            $person = factory(Person::class)->create();

            $user->person_id = $person->id;
            $user->save();
        });
    }
}
