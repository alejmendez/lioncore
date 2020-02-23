namespace Modules\{{ $json['module'] }}\Tests\Feature;

use Modules\{{ $json['module'] }}\Models\{{ ucwords($nameModel) }};
use Tests\TestCase;

class {{ ucwords($nameModel) }}Test extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            @foreach ($fields as $field)
'{!! $field['name'] !!}' => $faker->{!! $field['faker'] !!},
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

        $this->json('POST', route('{{ $nameModel }}s.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_update_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $data = $this->generateData();

        $this->json('PUT', route('{{ $nameModel }}s.update', ${{ $nameModel }}->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_show_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $this->json('GET', route('{{ $nameModel }}s.show', ${{ $nameModel }}->id))
            ->assertStatus(200);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_delete_{{ $nameModel }}()
    {
        ${{ $nameModel }} = factory({{ ucwords($nameModel) }}::class)->create();

        $this->json('DELETE', route('{{ $nameModel }}s.destroy', ${{ $nameModel }}->id))
            ->assertStatus(200);
    }

    /**
     * @group {{ $nameModel }}
     * @test
     */
    public function test_can_list_{{ $nameModel }}s()
    {
        ${{ $nameModel }}s = factory({{ ucwords($nameModel) }}::class, 2)->create()->map(function (${{ $nameModel }}) {
            return ${{ $nameModel }}->only([{!! $fieldsInList !!}]);
        });

        $this->json('GET', route('{{ $nameModel }}s.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        {!! $fieldsInList !!}
                    ]
                ],
            ]);
    }
}
