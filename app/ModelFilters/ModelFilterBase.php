<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ModelFilterBase extends ModelFilter
{
    public $relations = [];
    public $allFieldsSearch = [];

    public function allFields($value)
    {
        foreach ($this->allFieldsSearch as $field) {
            $this->whereLike($field, $value, 'or');
        }
        return $this;
    }
}
