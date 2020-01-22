
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {{ ucwords($nameModel) }}Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        @foreach ($jsonContent as $field)
    "{{ $field['name'] }}" => {!! json_encode($field['validations']) !!},
        @endforeach
];
    }
}