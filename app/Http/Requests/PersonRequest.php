<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PersonRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
            "dni" => "max:15",
            "first_name" => "max:80",
            "last_name" => "max:80",
            "company" => "max:80",
            "avatar" => "max:80",
            "room_telephone" => "max:15",
            "mobile_phone" => "max:15",
            "website" => "max:15",
            "languages" => "max:15",
            "email" => "max:80",
            "nationality" => "max:80",
            "gender" => "max:2",
            "civil_status" => "max:1",
            "contact_options" => "max:50",
            "address" => "max:80",
            "address2" => "max:80",
            "postcode" => "max:80",
            "city" => "max:80",
            "state" => "max:80",
            "country" => "max:80",
            "observation" => "max:255",
            "blood_type" => "max:5",
        ];
}
