<?php

namespace App\JsonApi\Users;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @param \App\User $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\User $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'id'        => $resource->id,
            'name'      => $resource->name,
            'email'     => $resource->email,
            'username'  => $resource->username,
            'status'    => $resource->status,
            'createdAt' => $resource->created_at->toAtomString(),
            'updatedAt' => $resource->updated_at->toAtomString(),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'people' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }
}
