<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roles = $this->roles->pluck('name');
        $instance = $this->resource;
        $person = $instance->person;
        return [
            'id'              => $instance->id,
            'name'            => $instance->name,
            'email'           => $instance->email,
            'username'        => $instance->username,
            'status'          => $instance->status,
            'role'            => $roles->first(),
            'roles'           => $roles,
            'dni'             => $person->dni,
            'first_name'      => $person->first_name,
            'last_name'       => $person->last_name,
            'company'         => $person->company,
            'avatar'          => $person->avatar,
            'birthdate'       => $person->birthdate,
            'room_telephone'  => $person->room_telephone,
            'mobile_phone'    => $person->mobile_phone,
            'website'         => $person->website,
            'languages'       => explode(',', $person->languages),
            'email'           => $person->email,
            'nationality'     => $person->nationality,
            'gender'          => $person->gender,
            'civil_status'    => $person->civil_status,
            'contact_options' => explode(',', $person->contact_options),
            'address'         => $person->address,
            'address2'        => $person->address2,
            'postcode'        => $person->postcode,
            'city'            => $person->city,
            'state'           => $person->state,
            'country'         => $person->country,
            'number_children' => $person->number_children,
            'observation'     => $person->observation,
            'blood_type'      => $person->blood_type,
        ];
    }
}
