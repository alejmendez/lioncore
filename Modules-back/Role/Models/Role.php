<?php

namespace Modules\Role\Models;

use Spatie\Permission\Models\Role as RoleBase;
use Modules\Core\Models\AutoGenerateUuid;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends RoleBase implements Auditable
{
    use AutoGenerateUuid, \OwenIt\Auditing\Auditable, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';
}
