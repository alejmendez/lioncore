<?php

namespace Modules\Core\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Modules\Core\Models\AutoGenerateUuid;

abstract ModelBase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, AutoGenerateUuid;
}
