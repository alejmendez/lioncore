<?php
namespace App\Models;

use App\Models\ModelBase;

class Field extends ModelBase
{
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function form()
    {
        return $this->belongsTo('App\Models\Form');
    }
}
