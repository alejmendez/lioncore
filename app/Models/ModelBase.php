<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AutoGenerateUuid;

abstract class ModelBase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, AutoGenerateUuid;
}
