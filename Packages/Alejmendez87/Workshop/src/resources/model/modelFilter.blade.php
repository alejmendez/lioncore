
namespace App\ModelFilters;

class {{ ucwords($nameModel) }}Filter extends ModelFilterBase
{
    public $relations = [];@foreach ($fields as $field)

    public function {!! $field['name'] !!}($value)
    {
        return $this->whereLike('{!! $field['name'] !!}', $value);
    }
@endforeach
}
