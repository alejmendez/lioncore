<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public $collects = PermissionResource::class;

    public function toArray($request)
    {
        return $this->collection;
    }
}
