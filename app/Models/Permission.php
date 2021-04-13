<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as PermissionBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AutoGenerateUuid;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends PermissionBase implements Auditable
{
    use HasFactory, AutoGenerateUuid, \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    protected $keyType = 'string';
    public $modules = [
        'person',
        'user',
        'role',
        'property',
    ];
    public $modulesPermission = [
        'list',
        'show',
        'store',
        'update',
        'destroy',
        'module-data',
        'filters',
    ];
    public $permissionsExtra = [
        'chat view',
    ];
}
