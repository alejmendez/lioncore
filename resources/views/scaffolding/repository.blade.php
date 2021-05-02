
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\{{ ucwords($nameModel) }}Request;

// Modelos
use App\Models\{{ ucwords($nameModel) }};

class {{ ucwords($nameModel) }}Controller extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = {{ ucwords($nameModel) }}::select('id', {!! $fieldsInList !!});
        return datatables()->of($query)->make(true);
    }

    public function filters()
    {
        $filters = [];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $moduleData = [];

        return $this->showResponse($moduleData);
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
