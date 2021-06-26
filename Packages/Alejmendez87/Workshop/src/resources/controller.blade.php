
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\{{ $nameModel }}Request;
use App\Http\Resources\{{ $nameModel }}Collection;
use App\Http\Resources\{{ $nameModel }}Resource;
use App\Models\{{ $nameModel }};
use App\Repositories\{{ $nameModel }}Repository;

class {{ $nameModel }}Controller extends BaseController
{
    use ApiResponse;

    public function __construct({{ $nameModel }}Repository ${{ $nameModelLower }}Repository)
    {
        $this->{{ $nameModelLower }}Repository = ${{ $nameModelLower }}Repository;
    }

    public function index()
    {
        ${{ $nameRoutePlural }} = $this->{{ $nameModelLower }}Repository->paginate(request()->all());
        return {{ $nameModel }}Collection::make(${{ $nameRoutePlural }});
    }

    public function show($id)
    {
        ${{ $nameModelLower }} = $this->{{ $nameModelLower }}Repository->find($id);
        return {{ $nameModel }}Resource::make(${{ $nameModelLower }});
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

    public function store({{ $nameModel }}Request $request)
    {
        ${{ $nameModelLower }} = $this->{{ $nameModelLower }}Repository->create($request->all());
        return {{ $nameModel }}Resource::make(${{ $nameModelLower }});
    }

    public function update({{ $nameModel }}Request $request, $id)
    {
        ${{ $nameModelLower }} = $this->{{ $nameModelLower }}Repository->update($id, $request->all());
        return {{ $nameModel }}Resource::make(${{ $nameModelLower }});
    }

    public function destroy($id)
    {
        ${{ $nameModelLower }} = $this->{{ $nameModelLower }}Repository->destroy($id);
        return ${{ $nameModelLower }};
    }
}
