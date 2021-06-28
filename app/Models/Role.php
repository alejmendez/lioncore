<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleBase;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\AutoGenerateUuid;

class Role extends RoleBase implements Auditable
{
    use HasFactory, AutoGenerateUuid, \OwenIt\Auditing\Auditable, SoftDeletes, Filterable;

    public $incrementing = false;

    protected $keyType = 'string';
}
