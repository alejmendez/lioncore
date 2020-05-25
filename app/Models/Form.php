<?php
namespace App\Models;

use App\Models\ModelBase;

class Form extends ModelBase
{
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function fields()
    {
        return $this->hasMany('App\Models\Field');
    }

    // "name": "dni",
    // "type": "string",
    // "length": 80,
    // "label": "dni",
    // "htmlType": "text",
    // "validations": "required,min:3,max:80",
    // "searchable": true,
    // "inForm": true,
    // "inList": true

    public function getSearchables()
    {
        return $this->fields->filter(function($field) {
            return $field->get('searchable', false);
        });
    }

    public function getInForm()
    {
        return $this->fields->filter(function($field) {
            return !!$field->inForm;
        });
    }

    public function getInList()
    {
        return $this->fields->filter(function($field) {
            return !!$field->inList;
        });
    }

    public function getValidations()
    {
        return $this->fields->filter(function($field) {
            return !!$field->validations;
        })->map(function($field) {
            return [
                $field->name => $field->validations
            ];
        });
    }
}
