<?php
namespace App\ModelFilters;

class EmployeeFilter extends ModelFilterBase
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

    public function code($value)
    {
        return $this->whereLike('code', $value);
    }

    public function position($value)
    {
        return $this->whereLike('position', $value);
    }

    public function group_id($value)
    {
        return $this->whereLike('group_id', $value);
    }

    public function date_admission($value)
    {
        return $this->whereLike('date_admission', $value);
    }

    public function salary($value)
    {
        return $this->whereLike('salary', $value);
    }

    public function allFields($value)
    {
        parent::allFields($value);

        $this->leftJoin('people', 'users.person_id', '=', 'people' . '.id');
        foreach ($this->relations['person'] as $field) {
            $this->whereLike('people.' . $field, $value, 'or');
        }
    }
}
