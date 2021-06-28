<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;
        $person = $resource->person;

        return [
            'id'              => $resource->id,
            'code'            => $resource->code,
            'position'        => $resource->position,
            'group_id'        => $resource->group_id,
            'date_admission'  => $resource->date_admission,
            'salary'          => $resource->salary,
            'person_id'       => $person->id,
            'dni'             => $person->dni,
            'about'           => $person->about,
            'first_name'      => $person->first_name,
            'last_name'       => $person->last_name,
            'full_name'       => $person->full_name,
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
}
