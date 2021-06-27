
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\{{ ucwords($nameModel) }}Repository;

class Eloquent{{ ucwords($nameModel) }}Repository extends EloquentBaseRepository implements {{ ucwords($nameModel) }}Repository
{
}
