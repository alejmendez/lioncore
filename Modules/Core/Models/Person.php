<?php

namespace Modules\Core\Models;

use Modules\Core\Models\ModelBase;

class Person extends ModelBase
{
    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'address',
        'birthdate',
        'civil_status',
        'room_telephone',
        'mobile_phone',
        'email',
        'nationality',
        'gender',
        'height',
        'weight',
        'shirt_size',
        'size_pants',
        'shoe_size',
        'profession',
        'academic_level',
        'country',
        'state',
        'municipality',
        'parish',
        'military_component',
        'military_rank',
        'number_children',
        'spouse_works',
        'observation',
        'photos',
        'turn',
        'schedule',
        'blood_type',
        'file_number',
        'management',
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function user()
    {
        return $this->hasOne('Modules\User\Models\User');
    }
}
