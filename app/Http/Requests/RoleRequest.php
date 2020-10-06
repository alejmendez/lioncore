<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class RoleRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        'name' => 'required|min:3|max:80',
        'permissions.*' => 'uuid',
    ];
}
