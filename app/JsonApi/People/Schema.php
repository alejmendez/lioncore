<?php

namespace App\JsonApi\People;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'people';

    /**
     * @param \App\Person $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Person $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'dni'            => $resource->dni,
            'first_name'     => $resource->first_name,
            'last_name'      => $resource->last_name,
            'company'        => $resource->company,
            'avatar'         => $resource->avatar,
            'birthdate'      => $resource->birthdate,
            'room_telephone' => $resource->room_telephone,
            'mobile_phone'   => $resource->mobile_phone,
            'website'        => $resource->website,
            'languages'      => $resource->languages,
            'email'          => $resource->email,
            'nationality'    => $resource->nationality,
            'gender'         => $resource->gender,
            'civil_status'   => $resource->civil_status,
            'contact_options'=> $resource->contact_options,
            'address'        => $resource->address,
            'address2'       => $resource->address2,
            'postcode'       => $resource->postcode,
            'city'           => $resource->city,
            'state'          => $resource->state,
            'country'        => $resource->country,
            'number_children'=> $resource->number_children,
            'observation'    => $resource->observation,
            'blood_type'     => $resource->blood_type,
            'createdAt'      => $resource->created_at,
            'updatedAt'      => $resource->updated_at,
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'users' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],
            'employes' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }

}
