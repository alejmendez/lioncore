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

        foreach ($this->relations as $relationName => $relationFields) {
            foreach ($relationFields as $field) {
                $this->related($relationName, function($query) use ($value, $field) {
                    return $query->whereLike($field, $value, 'or');
                });
            }
        }
        return $this;
    }
}
