namespace Modules\{{ $json['module'] }}\Tests\Feature;

use Modules\{{ $json['module'] }}\Models\{{ ucwords($nameModel) }};
use Tests\TestCase;

class {{ ucwords($nameModel) }}Test extends TestCase
{
    protected function generateData()
    {
        return [
            @foreach ($fields as $field)
'{!! $field['name'] !!}' => $this->faker->sentence,
            @endforeach
        ];
    }

    /** @test */
    public function test_can_create_{{ $nameModel }}()
    {
        $data = $this->generateData();

        $this->{{ $nameModel }}(route('{{ $nameModel }}.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /** @test */
    public function test_can_update_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $data = $this->generateData();

        $this->put(route('{{ $nameModel }}.update', ${{ $nameModel }}->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    /** @test */
    public function test_can_show_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $this->get(route('{{ $nameModel }}.show', ${{ $nameModel }}->id))
            ->assertStatus(200);
    }

    /** @test */
    public function test_can_delete_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $this->delete(route('{{ $nameModel }}.delete', ${{ $nameModel }}->id))
            ->assertStatus(204);
    }

    /** @test */
    public function test_can_list_{{ $nameModel }}s()
    {
        ${{ $nameModel }}s = factory({{ ucwords($nameModel) }}::class, 2)->create()->map(function (${{ $nameModel }}) {
            return ${{ $nameModel }}->only([{!! $fieldsInList !!}]);
        });

        $this->get(route('{{ $nameModel }}'))
            ->assertStatus(200)
            ->assertJson(${{ $nameModel }}s->toArray())
            ->assertJsonStructure([
                '*' => [{!! $fieldsInList !!}],
            ]);
    }
}