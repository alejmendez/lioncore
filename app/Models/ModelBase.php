<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AutoGenerateUuid;

abstract class ModelBase extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, AutoGenerateUuid;
}
