<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PropertyRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "name"  => "min:3|max:50",
        "value" => "min:3|max:50",
    ];
}
