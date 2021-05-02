<?php

namespace App\Models;

use Spatie\Permission\Models\Role as RoleBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AutoGenerateUuid;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends RoleBase implements Auditable
{
    use HasFactory, AutoGenerateUuid, \OwenIt\Auditing\Auditable, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';
}
