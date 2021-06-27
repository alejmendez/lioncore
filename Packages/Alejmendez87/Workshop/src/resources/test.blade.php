namespace App\Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\{{ ucwords($nameModel) }};

class {{ ucwords($nameModel) }}Test extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

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

    public function test_can_create_{{ $nameModel }}()
    {
        $data = $this->generateData();

        $response = $this->postJson(route('api.v1.{{ $nameModelPlural }}.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $data = $this->generateData();

        $response = $this->putJson(route('api.v1.{{ $nameModelPlural }}.update', ${{ $nameModel }}->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('{{ $nameModelPlural }}', [
            'name' => $data['name'],
        ]);
    }

    public function test_can_fetch_single_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $response = $this->getJson(route('api.v1.{{ $nameModelPlural }}.show', ${{ $nameModel }}->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_{{ $nameModel }}()
    {
        ${{ $nameModel }} = {{ ucwords($nameModel) }}::factory()->create();

        $response = $this->deleteJson(route('api.v1.{{ $nameModelPlural }}.destroy', ${{ $nameModel }}->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted(${{ $nameModel }});
    }

    public function test_can_list_{{ $nameModelPlural }}()
    {
        {{ ucwords($nameModel) }}::factory()->times(3)->create();

        $response = $this->getJson(route('api.v1.{{ $nameModelPlural }}.index') . '?page=1&per_page=5');
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
