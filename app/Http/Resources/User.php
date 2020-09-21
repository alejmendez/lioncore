<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roles = $this->roles->pluck('name');
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'username'        => $this->username,
            'status'          => $this->status,
            'role'            => $roles->first(),
            'roles'           => $roles,
            'dni'             => $this->person->dni,
            'first_name'      => $this->person->first_name,
            'last_name'       => $this->person->last_name,
            'company'         => $this->person->company,
            'avatar'          => $this->person->avatar,
            'birthdate'       => $this->person->birthdate,
            'room_telephone'  => $this->person->room_telephone,
            'mobile_phone'    => $this->person->mobile_phone,
            'website'         => $this->person->website,
            'languages'       => explode(', ', $this->person->languages),
            'email'           => $this->person->email,
            'nationality'     => $this->person->nationality,
            'gender'          => explode(', ', $this->person->gender),
            'civil_status'    => $this->person->civil_status,
            'contact_options' => explode(', ', $this->person->contact_options),
            'address'         => $this->person->address,
            'address2'        => $this->person->address2,
            'postcode'        => $this->person->postcode,
            'city'            => $this->person->city,
            'state'           => $this->person->state,
            'country'         => $this->person->country,
            'number_children' => $this->person->number_children,
            'observation'     => $this->person->observation,
            'blood_type'      => $this->person->blood_type,
        ];
    }
}
