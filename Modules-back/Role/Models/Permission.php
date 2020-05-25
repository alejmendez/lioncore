<?php

namespace Modules\Role\Models;

use Spatie\Permission\Models\Permission as PermissionBase;
use Modules\Core\Models\AutoGenerateUuid;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends PermissionBase implements Auditable
{
    use AutoGenerateUuid, \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    protected $keyType = 'string';
}
