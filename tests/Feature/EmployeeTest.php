<?php
namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\Employee;

class EmployeeTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function generateData()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $username = Str::slug($firstName) . '.' . Str::slug($lastName) . $this->faker->numberBetween(1, 99999);
        $email    = $username . '@gmail.com';

        $languages = [$this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit'])];
        $contact_options = [$this->faker->randomElement(['email', 'message', 'phone'])];

        return [
            'code'               => $this->faker->randomLetter . $this->faker->numberBetween(1, 500),
            'position'           => $this->faker->word(),
            'group_id'           => $this->faker->Uuid(),
            'date_admission'     => $this->faker->date('Y-m-d', '-5 years'),
            'salary'             => $this->faker->numberBetween(500000, 3000000),
            'dni'                => $this->faker->numberBetween(5000000, 30000000),
            'first_name'         => $firstName,
            'last_name'          => $lastName,
            'avatar'             => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate'          => $this->faker->date('Y-m-d', '-18 years'),
            'room_telephone'     => $this->faker->phoneNumber,
            'mobile_phone'       => $this->faker->phoneNumber,
            'website'            => $this->faker->url,
            'languages'          => $languages,
            'email'              => $email,
            'nationality'        => $this->faker->randomElement(['C', 'E']),
            'gender'             => $this->faker->randomElement(['male', 'female', 'other']),
            'civil_status'       => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options'    => $contact_options,
            'address'            => $this->faker->address,
            'address2'           => $this->faker->secondaryAddress,
            'postcode'           => $this->faker->postcode,
            'city'               => $this->faker->city,
            'state'              => $this->faker->state,
            'country'            => $this->faker->country,
            'number_children'    => $this->faker->numberBetween(0, 5),
            'observation'        => $this->faker->text(250),
            'blood_type'         => $this->faker->randomElement(['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-', 'ARH+', 'BRH+', 'ABRH+', 'ORH+', 'ARH-', 'BRH-', 'ABRH-', 'ORH-']),
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
            'code',
            'position',
            'group_id',
            'date_admission',
            'salary',
            'dni',
            'first_name',
            'last_name',
            'full_name',
            'company',
            'avatar',
            'birthdate',
            'room_telephone',
            'mobile_phone',
            'website',
            'languages',
            'email',
            'nationality',
            'gender',
            'civil_status',
            'contact_options',
            'address',
            'address2',
            'postcode',
            'city',
            'state',
            'country',
            'number_children',
            'observation',
            'blood_type'
        ];
    }

    public function test_can_create_employee()
    {
        $data = $this->generateData();
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.v1.employees.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_employee()
    {
        $employee = Employee::factory()->create();

        $data = $this->generateData();

        $response = $this->putJson(route('api.v1.employees.update', $employee->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('employees', [
            'code' => $data['code'],
        ]);
    }

    public function test_can_fetch_single_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->getJson(route('api.v1.employees.show', $employee->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->deleteJson(route('api.v1.employees.destroy', $employee->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted($employee);
    }

    public function test_can_list_employees()
    {
        Employee::factory()->times(3)->create();

        $response = $this->getJson(route('api.v1.employees.index') . '?page=1&per_page=5');
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'self',
                'links',
                'meta',
                'data' => [$this->getListElementData()],
            ]);
    }
}
