namespace Modules\{{ $json['module'] }}\Http\Requests;

use Modules\Core\Http\Requests\FormRequest;

class {{ ucwords($nameModel) }}Request extends FormRequest
{
    protected $fieldId = '{{ $json['id'] }}';
    protected $rules = [
        @foreach ($fields as $field)
    "{{ $field['name'] }}" => {!! json_encode($field['validations']) !!},
        @endforeach
];
}
