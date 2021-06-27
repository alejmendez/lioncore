
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class {{ $nameModel }}Collection extends ResourceCollection
{
    public $collects = {{ $nameModel }}Resource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'self' => route('api.v1.{{ strtolower($nameRoutePlural) }}.index')
        ];
    }
}
