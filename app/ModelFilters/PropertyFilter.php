<?php
namespace App\ModelFilters;

class PropertyFilter extends ModelFilterBase
{
    public $relations = [];
    public function name($value)
    {
        return $this->whereLike('name', $value);
    }

    public function value($value)
    {
        return $this->whereLike('value', $value);
    }
}
