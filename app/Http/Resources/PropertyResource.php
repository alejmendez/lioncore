<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'value' => $resource->value
        ];
    }
}
