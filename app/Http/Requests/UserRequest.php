<?php
namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{
    protected $fieldId = 'id';
    protected $rules = [
        'person_id'          => 'uuid|exists:people,id',
        'username'           => 'required|regex:/^[\w\.\-]+$/u',
        'email'              => 'required|email|min:10|max:80|unique:users',
        'password'           => 'required|min:6|max:30',
        'status'             => 'required|alpha',
        'dni'                => 'required|max:15',
        'first_name'         => 'required|max:80',
        'last_name'          => 'alpha|max:80',
        'company'            => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:80',
        'avatar'             => 'max:200',
        'birthdate'          => 'date',
        'room_telephone'     => 'regex:/^[\d \+\-\(\)]+$/u|max:15',
        'mobile_phone'       => 'regex:/^[\d \+\-\(\)]+$/u|max:15',
        'website'            => 'url|max:255',
        'languages'          => 'array|max:80',
        'nationality'        => 'alpha|max:80',
        'gender'             => 'alpha|max:10',
        'civil_status'       => 'alpha|max:1',
        'contact_options'    => 'array|max:100',
        'address'            => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:200',
        'address2'           => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:200',
        'postcode'           => 'digits_between:5,8',
        'city'               => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:80',
        'state'              => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:80',
        'country'            => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:80',
        'number_children'    => 'integer',
        'observation'        => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:255',
        'about'              => 'regex:/^[- ,\/\w\d\. áéíóúÁÉÍÓÚñÑ\'º]+$/u|max:255',
        'blood_type'         => 'regex:/^[\+\-a-zA-Z]+$/u|max:5'
    ];
}
