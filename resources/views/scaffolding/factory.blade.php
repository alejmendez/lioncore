use Modules\{{ $json['module'] }}\Models\{{ ucwords($nameModel) }};
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define({{ ucwords($nameModel) }}::class, function (Faker $faker) {
    return [
        @foreach ($fields as $field)
    "{{ $field['name'] }}" => $faker->{!! $field['faker'] !!},
        @endforeach
    ];
});
