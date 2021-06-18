<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'self' => route('api.v1.users.index')
        ];
    }
}
