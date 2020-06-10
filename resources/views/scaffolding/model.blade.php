namespace App\Models;

use App\Models\ModelBase;

class {{ ucwords($nameModel) }} extends ModelBase
{
    protected $fillable = [
        @foreach ($fillable as $field)
{!! $field !!},
        @endforeach
    ];
}
