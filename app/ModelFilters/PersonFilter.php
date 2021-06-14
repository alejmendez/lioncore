<?php

namespace App\ModelFilters;

class PersonFilter extends ModelFilterBase
{
    public $relations = [];

    public function dni($value)
    {
        return $this->whereLike('dni', $value);
    }

    public function firstName($value) {
        return $this->whereLike('first_name', $value);
    }

    public function lastName($value) {
        return $this->whereLike('last_name', $value);
    }

    public function company($value) {
        return $this->whereLike('company', $value);
    }

    public function avatar($value) {
        return $this->whereLike('avatar', $value);
    }

    public function birthdate($value) {
        return $this->whereLike('birthdate', $value);
    }

    public function roomTelephone($value) {
        return $this->whereLike('room_telephone', $value);
    }

    public function mobilePhone($value) {
        return $this->whereLike('mobile_phone', $value);
    }

    public function website($value) {
        return $this->whereLike('website', $value);
    }

    public function languages($value) {
        return $this->whereLike('languages', $value);
    }

    public function email($value) {
        return $this->whereLike('email', $value);
    }

    public function nationality($value) {
        return $this->whereLike('nationality', $value);
    }

    public function gender($value) {
        return $this->whereLike('gender', $value);
    }

    public function civilStatus($value) {
        return $this->whereLike('civil_status', $value);
    }

    public function contactOptions($value) {
        return $this->whereLike('contact_options', $value);
    }

    public function address($value) {
        return $this->whereLike('address', $value);
    }

    public function address2($value) {
        return $this->whereLike('address2', $value);
    }

    public function postcode($value) {
        return $this->whereLike('postcode', $value);
    }

    public function city($value) {
        return $this->whereLike('city', $value);
    }

    public function state($value) {
        return $this->whereLike('state', $value);
    }

    public function country($value) {
        return $this->whereLike('country', $value);
    }

    public function numberChildren($value) {
        return $this->whereLike('number_children', $value);
    }

    public function observation($value) {
        return $this->whereLike('observation', $value);
    }

    public function bloodType($value) {
        return $this->whereLike('blood_type', $value);
    }
}
