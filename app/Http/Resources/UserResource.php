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
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $resource = $this->resource;
        $person = $resource->person;

        return [
            'id'              => $resource->id,
            'displayName'     => $resource->getFullNameAttribute(),
            'username'        => $resource->username,
            'status'          => $resource->status,
            'name'            => $resource->full_name,
            'fullName'       => $resource->full_name,
            'role'            => $roles,
            'permissions'     => $permissions,
            'personId'       => $person->id,
            'dni'             => $person->dni,
            'about'           => $person->about,
            'firstName'      => $person->first_name,
            'lastName'       => $person->last_name,
            'company'         => $person->company,
            'avatar'          => $person->avatar,
            'birthdate'       => $person->birthdate,
            'roomTelephone'  => $person->room_telephone,
            'mobilePhone'    => $person->mobile_phone,
            'website'         => $person->website,
            'languages'       => $person->languages,
            'email'           => $person->email,
            'nationality'     => $person->nationality,
            'gender'          => $person->gender,
            'civilStatus'    => $person->civil_status,
            'contactOptions' => $person->contact_options,
            'address'         => $person->address,
            'address2'        => $person->address2,
            'postcode'        => $person->postcode,
            'city'            => $person->city,
            'state'           => $person->state,
            'country'         => $person->country,
            'numberChildren' => $person->number_children,
            'observation'     => $person->observation,
            'bloodType'      => $person->blood_type,
        ];
    }

    public function getRoles()
    {
        return $this->roles->map(function($role) {
            return [
                $role->id,
                $role->name
            ];
        });
    }

    public function getPermissions()
    {
        $permissions = collect();

        $this->roles->each(function($role) use($permissions) {
            $role->permissions->each(function($permission) use($permissions) {
                $permissions->push($permission->name);
            });
        });

        return $permissions->unique()->sort()->values();
    }
}
