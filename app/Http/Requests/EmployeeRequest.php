<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class EmployeeRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "code" => "max:20",
        "position" => "max:50",
        "group_id" => "max:36",
    ];
}
