<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'avatar',
        'birthdate',
        'room_telephone',
        'mobile_phone',
        'website',
        'languages',
        'email',
        'nationality',
        'gender',
        'civil_status',
        'contact_options',
        'address',
        'address2',
        'postcode',
        'city',
        'state',
        'country',
        'number_children',
        'observation',
        'about',
        'blood_type',
    ];

    public function setEmailAttribute($email)
    {
        if (!empty($email)) {
            $this->attributes['email'] = strtolower($email);
        }
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
