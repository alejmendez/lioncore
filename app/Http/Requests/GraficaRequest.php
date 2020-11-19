<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class GraficaRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "title" => "required,min:3,max:250",
    ];
}
