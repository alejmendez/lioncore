<?php

namespace App\ModelFilters;

class UserFilter extends ModelFilterBase
{
    public $relations = [
        'person' => [
            'dni',
            'first_name',
            'last_name',
            'company',
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
            'blood_type',
        ],
    ];

    public $allFieldsSearch = [
        'username',
        'status',
    ];

    public function username($value)
    {
        return $this->whereLike('username', $value);
    }

    public function status($value)
    {
        return $this->whereLike('status', $value);
    }
}
