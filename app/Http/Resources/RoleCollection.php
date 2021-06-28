<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = RoleResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'self' => route('api.v1.roles.index')
        ];
    }
}
