<?php

namespace App\JsonApi\Employees;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'employees';

    /**
     * @param \App\Employee $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Employee $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'code'           => $resource->code,
            'position'       => $resource->position,
            'group_id'       => $resource->group_id,
            'date_admission' => $resource->date_admission,
            'salary'         => $resource->salary,
            'createdAt'      => $resource->created_at,
            'updatedAt'      => $resource->updated_at,
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
