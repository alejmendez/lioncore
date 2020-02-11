
namespace App\Http\Controllers\Core;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;
use App\Traits\RestControllerTrait;

// Request
use Illuminate\Http\Request;
use App\Http\Request\{{ ucwords($nameModel) }}Request;

// Modelos
use App\Models\{{ ucwords($nameModel) }};

/**
 * Controlador de usuarios
 *
 * {{ '@' }}category Controller
 * {{ '@' }}package  App\Http\Controllers\Core
 * {{ '@' }}author   Alejandro Méndez <alejmendez.87@gmail.com>
 * {{ '@' }}license  http://www.opensource.org/licenses/mit-license.html MIT
 * {{ '@' }}link     http://url.com
 */
class {{ ucwords($nameModel) }}Controller extends BaseController
{
    use RestControllerTrait, ApiResponse;

    const MODEL = 'App\Models\{{ ucwords($nameModel) }}';
    const PERMISSION = '{{ strtolower($nameModel) }}';

    const selectOne = {!! $fieldsSelect !!};
    const selectAll = {!! $fieldsSelect !!};

    protected $validations = [
        @foreach ($this->json as $field)
    "{{ $field['name'] }}" => {!! json_encode($field['validations']) !!},
        @endforeach
];
}
