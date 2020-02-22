<?php
namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
            "person_id" => "exists:people,id",
            "email" => "email|min:10|max:80",
            "password" => "min:6|max:30",
            "verification_token" => "max:64",
        ];
}
