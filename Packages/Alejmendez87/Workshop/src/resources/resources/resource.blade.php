
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class {{ ucwords($nameModel) }}Resource extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
{!! $fields !!}
        ];
    }
}
