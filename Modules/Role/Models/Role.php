<?php

namespace Modules\Role\Models;

use Spatie\Permission\Models\Role as RoleBase;
use Modules\Core\Models\AutoGenerateUuid;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends RoleBase implements Auditable
{
    use AutoGenerateUuid, \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    protected $keyType = 'string';
}
