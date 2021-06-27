
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\{{ ucwords($nameModel) }}Repository;

class Cache{{ ucwords($nameModel) }}Decorator extends BaseCacheDecorator implements {{ ucwords($nameModel) }}Repository
{
    public function __construct({{ ucwords($nameModel) }}Repository ${{ $nameModel }})
    {
        parent::__construct();
        $this->entityName = '{{ ucwords($nameModel) }}.{{ ucwords($nameRoutePlural) }}';
        $this->repository = ${{ $nameModel }};
    }
}
