namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

use App\Models\{{ ucwords($nameModel) }};

class {{ ucwords($nameModel) }}Test extends TestCase
{
    protected function generateData()
    {
        return [
@foreach ($fields as $field)
            '{!! $field['name'] !!}' => $this->faker->{!! $field['faker'] !!},
@endforeach
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
@foreach ($fields as $field)
            '{!! $field['name'] !!}',
@endforeach
        ];
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_create_{{ $nameModel }}()
    {
        $data = $this->generateData();
        Log::debug('[test_can_create_{{ $nameModel }}] Data used for property creation: ');
        Log::debug(json_encode($data));

        $response = $this->postJson(route('{{ $nameModelPlural }}.store'), $data);
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
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_update_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $data = $this->generateData();
        Log::debug('[test_can_update_{{ $nameModel }}] {{ ucwords($nameModel) }} created');
        Log::debug(json_encode($data));

        Log::debug('[test_can_update_{{ $nameModel }}] Data used for {{ $nameModel }} update: ');
        Log::debug(json_encode($data));

        $response = $this->putJson(route('{{ $nameModelPlural }}.update', ${{ $nameModel }}->id), $data);
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('{{ $nameModelPlural }}', [
            'name' => $data['name'],
        ]);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_show_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $response = $this->getJson(route('{{ $nameModelPlural }}.show', ${{ $nameModel }}->id));
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('{{ $nameModelPlural }}', [
            'name' => ${{ $nameModel }}->name,
        ]);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_delete_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $response = $this->deleteJson(route('{{ $nameModelPlural }}.destroy', ${{ $nameModel }}->id));
        $response
            ->assertOk()
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        $this->assertSoftDeleted(${{ $nameModel }});
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_list_{{ $nameModelPlural }}()
    {
        {{ ucwords($nameModel) }}::factory(2)->create();

        $response = $this->getJson(route('{{ $nameModelPlural }}.index') . '?page=1&rowsPerPage=5');
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
