<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class AlumnoRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "firstName" => "required|min:3|max:50",
        "lastname" => "required|min:3|max:50",
        "phone" => "required|min:8|max:50",
        "email" => "email|min:10|max:80",
        "specialty" => "required|min:3|max:20",
        "semester" => "required|min:3|max:20",
    ];
}
