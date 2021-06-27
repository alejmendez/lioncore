<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class personResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'dni' => $resource->dni,
            'first_name' => $resource->first_name,
            'last_name' => $resource->last_name,
            'avatar' => $resource->avatar,
            'birthdate' => $resource->birthdate,
            'room_telephone' => $resource->room_telephone,
            'mobile_phone' => $resource->mobile_phone,
            'website' => $resource->website,
            'languages' => $resource->languages,
            'email' => $resource->email,
            'nationality' => $resource->nationality,
            'gender' => $resource->gender,
            'civil_status' => $resource->civil_status,
            'contact_options' => $resource->contact_options,
            'address' => $resource->address,
            'address2' => $resource->address2,
            'postcode' => $resource->postcode,
            'city' => $resource->city,
            'state' => $resource->state,
            'country' => $resource->country,
            'number_children' => $resource->number_children,
            'observation' => $resource->observation,
            'about' => $resource->about,
            'blood_type' => $resource->blood_type
        ];
    }
}
