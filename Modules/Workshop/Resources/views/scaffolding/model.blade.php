namespace Modules\{{ $json['module'] }}\Models;

use Modules\Core\Models\ModelBase;

class {{ ucwords($nameModel) }} extends ModelBase
{
    protected $fillable = [
        @foreach ($fillable as $field)
{!! $field !!},
        @endforeach
    ];
}
