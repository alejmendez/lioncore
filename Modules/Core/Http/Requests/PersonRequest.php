<?php
namespace Modules\core\Http\Requests;

use Modules\Core\Http\Request\FormRequest;

class PersonRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
            "dni" => "max:15",
            "first_name" => "max:80",
            "last_name" => "max:80",
            "address" => "max:80",
            "civil_status" => "max:20",
            "room_telephone" => "max:15",
            "mobile_phone" => "max:15",
            "email" => "max:80",
            "nationality" => "max:80",
            "gender" => "max:2",
            "shirt_size" => "max:2",
            "size_pants" => "max:2",
            "shoe_size" => "max:2",
            "profession" => "max:80",
            "academic_level" => "max:80",
            "country" => "max:80",
            "state" => "max:80",
            "municipality" => "max:80",
            "parish" => "max:80",
            "military_component" => "max:80",
            "military_rank" => "max:80",
            "spouse_works" => "max:80",
            "observation" => "max:255",
            "photos" => "max:255",
            "turn" => "max:80",
            "schedule" => "max:80",
            "blood_type" => "max:5",
            "file_number" => "max:80",
            "management" => "max:80",
            "organization_id" => "max:80",
        ];
}
