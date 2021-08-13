<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NavigationCollection extends ResourceCollection
{
    public $collects = NavigationResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'self' => route('api.v1.navigations.index')
        ];
    }
}
