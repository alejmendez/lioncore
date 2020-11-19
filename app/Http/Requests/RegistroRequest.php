<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class RegistroRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
            "title" => "required|min:3|max:250",
            "tutor" => "required|min:3|max:50",
            "consultancies" => "required",
            "documentation" => "required",
            "assignedDate" => "required",
            "presentation" => "required",
            "finalTome" => "required",
        ];
}
