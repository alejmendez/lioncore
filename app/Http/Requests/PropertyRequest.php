<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PropertyRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "name"  => ["required", "min:3", "max:50", "unique:properties,name"],
        "value" => ["required", "min:3", "max:250"],
    ];
}
