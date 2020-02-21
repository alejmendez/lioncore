<?php
namespace Modules\User\Http\Requests;

use Modules\Core\Http\Request\FormRequest;

class UserRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
            "person_id" => "required",
            "email" => "max:80",
            "password" => "max:64",
            "verification_token" => "max:64",
        ];
}
