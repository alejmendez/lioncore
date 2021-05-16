namespace Database\Factories;

use App\Models\{{ ucwords($nameModel) }};

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class {{ ucwords($nameModel) }}Factory extends Factory
{
    protected $model = {{ ucwords($nameModel) }}::class;

    public function definition()
    {
        return [
    @foreach ($fields as $field)
        '{{ $field['name'] }}' => $this->faker->{!! $field['faker'] !!},
    @endforeach
    ];
    }
}
