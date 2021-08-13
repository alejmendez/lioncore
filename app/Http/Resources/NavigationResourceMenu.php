<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NavigationResourceMenu extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'title' => $resource->title,
            'subtitle' => $resource->subtitle,
            'type' => $resource->type,
            'tooltip' => $resource->tooltip,
            'link' => $resource->link,
            'icon' => $resource->icon,
            'parent' => $resource->parent,
            'order' => $resource->order,
            'meta' => $resource->meta
        ];
    }
}
