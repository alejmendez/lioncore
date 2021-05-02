namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class {{ ucwords($nameModel) }} extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
@foreach ($fillable as $field)
        {!! $field !!},
@endforeach
    ];
}
