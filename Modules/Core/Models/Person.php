<?php

namespace Modules\Core\Models;

use Modules\Core\Models\ModelBase;

class Person extends ModelBase
{
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function user()
    {
        return $this->hasOne('Modules\User\Models\User');
    }
}
