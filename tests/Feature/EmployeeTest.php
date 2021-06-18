<?php
namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

use App\Models\Employee;

class EmployeeTest extends TestCase
{
    protected function generateData()
    {
        return [
            'code' => $this->faker->numberBetween(5000000, 30000000),
            'position' => $this->faker->numberBetween(5000000, 30000000),
            'group_id' => $this->faker->numberBetween(5000000, 30000000),
            'date_admission' => $this->faker->numberBetween(5000000, 30000000),
            'salary' => $this->faker->numberBetween(5000000, 30000000),
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
        ];
    }

    /**
     * @group  employee
     * @test
     */
    public function test_can_create_employee()
    {
        $data = $this->generateData();
        Log::debug('[test_can_create_employee] Data used for property creation: ');
        Log::debug(json_encode($data));

        $response = $this->postJson(route('employees.store'), $data);
        $response
            ->assertCreated()
            ->assertJson([
                'code' => 201,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    /**
     * @group  employee
     * @test
     */
    public function test_can_update_employee()
    {
        $employee = Employee::factory()->create();

        $data = $this->generateData();
        Log::debug('[test_can_update_employee] Employee created');
        Log::debug(json_encode($data));

        Log::debug('[test_can_update_employee] Data used for employee update: ');
        Log::debug(json_encode($data));

        $response = $this->putJson(route('employees.update', $employee->id), $data);
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('employees', [
            'name' => $data['name'],
        ]);
    }

    /**
     * @group  employee
     * @test
     */
    public function test_can_show_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->getJson(route('employees.show', $employee->id));
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('employees', [
            'name' => $employee->name,
        ]);
    }

    /**
     * @group  employee
     * @test
     */
    public function test_can_delete_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->deleteJson(route('employees.destroy', $employee->id));
        $response
            ->assertOk()
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        $this->assertSoftDeleted($employee);
    }

    /**
     * @group  employee
     * @test
     */
    public function test_can_list_employees()
    {
        Employee::factory(2)->create();

        $response = $this->getJson(route('employees.index') . '?page=1&rowsPerPage=5');
        // dd($response);
        $response
            ->assertOk()
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [$this->getListElementData()],
            ]);
    }
}
