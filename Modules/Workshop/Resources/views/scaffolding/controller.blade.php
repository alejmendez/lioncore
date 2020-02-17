
namespace Modules\{{ $json['module'] }}\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use Modules\core\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use Modules\{{ $json['module'] }}\Http\Request\{{ ucwords($nameModel) }}Request;

// Modelos
use Modules\{{ $json['module'] }}\Models\{{ ucwords($nameModel) }};

use DataTables;

class {{ ucwords($nameModel) }}Controller extends BaseController
{
    use ApiResponse;

    public function index()
    {
        return DataTables::of({{ ucwords($nameModel) }}::query())->make(true);
    }

    public function show($id)
    {
        $instance = {{ ucwords($nameModel) }}::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store({{ ucwords($nameModel) }}Request $request)
    {
        $instance = {{ ucwords($nameModel) }}::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update({{ ucwords($nameModel) }}Request $request, $id)
    {
        $instance = {{ ucwords($nameModel) }}::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = {{ ucwords($nameModel) }}::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
