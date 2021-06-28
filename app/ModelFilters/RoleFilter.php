<?php
namespace App\ModelFilters;

class RoleFilter extends ModelFilterBase
{
    public $relations = [];
    public function name($value)
    {
        return $this->whereLike('name', $value);
    }
}
