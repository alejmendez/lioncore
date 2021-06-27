<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PersonRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "dni"             => "max:15",
        "first_name"      => "max:80",
        "last_name"       => "max:80",
        "avatar"          => "max:200",
        "room_telephone"  => "max:100",
        "mobile_phone"    => "max:100",
        "website"         => "max:250",
        "languages"       => "max:100",
        "email"           => "max:80",
        "nationality"     => "max:80",
        "gender"          => "max:10",
        "civil_status"    => "max:1",
        "contact_options" => "max:100",
        "address"         => "max:200",
        "address2"        => "max:200",
        "postcode"        => "max:80",
        "city"            => "max:80",
        "state"           => "max:80",
        "country"         => "max:80",
        "observation"     => "max:255",
        "about"           => "max:255",
        "blood_type"      => "max:5",
    ];
}
