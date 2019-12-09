<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Person extends Momodel implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'user_id',
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
        // 'rif',
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

    public function user()
    {
        return $this->hasOne('Modules\User\User');
    }
}
