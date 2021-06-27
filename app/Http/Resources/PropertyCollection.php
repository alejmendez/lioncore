<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    public $collects = PropertyResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'self' => route('api.v1.properties.index')
        ];
    }
}
