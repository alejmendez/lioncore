<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Permission as PermissionBase;
use App\Traits\AutoGenerateUuid;

class Permission extends PermissionBase implements Auditable
{
    use HasFactory, AutoGenerateUuid, \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    protected $keyType = 'string';
}
