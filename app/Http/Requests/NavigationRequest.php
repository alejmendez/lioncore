<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class NavigationRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        "title"    => ["required", "min:3", "max:120"],
        "subtitle" => ["required", "min:3", "max:120"],
        "type"     => ["required", "min:3", "max:20"],
        "tooltip"  => ["required", "min:3", "max:120"],
        "link"     => ["required", "min:3", "max:200"],
        "icon"     => ["required", "min:3", "max:120"],
        "parent"   => "exists:navegations,id",
        "order"    => "integer",
        "meta"     => ["required", "min:3", "max:120"],
    ];
}
