<?php
namespace App\ModelFilters;

class NavigationFilter extends ModelFilterBase
{
    public $relations = [];
    public function title($value)
    {
        return $this->whereLike('title', $value);
    }

    public function subtitle($value)
    {
        return $this->whereLike('subtitle', $value);
    }

    public function type($value)
    {
        return $this->whereLike('type', $value);
    }

    public function tooltip($value)
    {
        return $this->whereLike('tooltip', $value);
    }

    public function link($value)
    {
        return $this->whereLike('link', $value);
    }

    public function icon($value)
    {
        return $this->whereLike('icon', $value);
    }

    public function parent($value)
    {
        return $this->whereLike('parent', $value);
    }

    public function meta($value)
    {
        return $this->whereLike('meta', $value);
    }
}
