<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NavigationResourceMenu extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $menu = $this->generateMenu($this->resource);
        return [
            'compact' => $menu,
            'default' => $menu,
            'futuristic' => $menu,
            'horizontal' => $menu,
        ];
    }

    protected function generateMenu($resource, $parentId = null)
    {
        return $resource->filter(function ($ele) use ($parentId) {
            return $ele->parent === $parentId;
        })->map(function ($ele) use ($resource) {
            $ele['children'] = $this->generateMenu($resource, $ele->id);
            return $this->elementFromMenuToArray($ele);
        })->toArray();
    }

    public function elementFromMenuToArray($ele)
    {
        $eleReturn = [
            'id'       => $ele->id,
            'title'    => $ele->title,
            'subtitle' => $ele->subtitle,
            'type'     => $ele->type,
            'tooltip'  => $ele->tooltip,
            'icon'     => $ele->icon,
            'link'     => $ele->link,
            'order'    => $ele->order,
            'meta'     => $ele->meta
        ];

        if (count($ele['children']) > 0) {
            $eleReturn['children'] = $ele['children'];
        }

        $eleReturn = array_filter($eleReturn, function($ele){
            return $ele !== NULL;
        });
        return $eleReturn;
    }
}
