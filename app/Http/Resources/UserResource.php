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
            'about'           => $person->about,
            'role'            => $roles,
            'permissions'     => $permissions,
            'username'        => $resource->username,
            'status'          => $resource->status,
            'person_id'       => $person->id,
            'dni'             => $person->dni,
            'first_name'      => $person->first_name,
            'last_name'       => $person->last_name,
            'full_name'       => $resource->full_name,
            'company'         => $person->company,
            'avatar'          => $person->avatar,
            'birthdate'       => $person->birthdate,
            'room_telephone'  => $person->room_telephone,
            'mobile_phone'    => $person->mobile_phone,
            'website'         => $person->website,
            'languages'       => $person->languages,
            'email'           => $person->email,
            'nationality'     => $person->nationality,
            'gender'          => $person->gender,
            'civil_status'    => $person->civil_status,
            'contact_options' => $person->contact_options,
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
